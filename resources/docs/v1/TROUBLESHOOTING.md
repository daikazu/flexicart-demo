# Troubleshooting

This guide covers common issues you may encounter when using FlexiCart and how to resolve them.

## Common Issues

### Cart Data Not Persisting Between Requests

**Symptoms:** Items disappear after page refresh or navigation.

**Solutions:**

1. **Check session configuration:**
   ```php
   // Ensure sessions are properly configured in config/session.php
   'driver' => env('SESSION_DRIVER', 'file'),
   ```

2. **Verify middleware is applied:**
   ```php
   // Ensure web middleware group is applied to your routes
   Route::middleware('web')->group(function () {
       // Your cart routes
   });
   ```

3. **If using database storage:**
   ```bash
   # Verify migrations have been run
   php artisan migrate:status

   # Run migrations if needed
   php artisan vendor:publish --tag="flexicart-migrations"
   php artisan migrate
   ```

4. **Check environment variable:**
   ```env
   # Ensure storage driver is set correctly
   CART_STORAGE=session  # or 'database'
   ```

### Price Calculation Errors

**Symptoms:** Unexpected totals, errors when adding items.

**Solutions:**

1. **Verify price values are numeric:**
   ```php
   // Correct
   Cart::addItem([
       'price' => 29.99,  // numeric value
   ]);

   // Incorrect
   Cart::addItem([
       'price' => '$29.99',  // string with currency symbol
   ]);
   ```

2. **Ensure currency codes are valid:**
   ```php
   // config/flexicart.php
   'currency' => 'USD',  // Must be valid ISO 4217 code
   ```

3. **Check for currency mismatches:**
   ```php
   // All prices should use the same currency
   $price1 = Price::from(10.00, 'USD');
   $price2 = Price::from(5.00, 'USD');  // Same currency
   $total = $price1->plus($price2);  // Works

   $price3 = Price::from(5.00, 'EUR');  // Different currency
   // $price1->plus($price3);  // Throws exception
   ```

### Condition Not Applying Correctly

**Symptoms:** Discounts or fees not showing in total.

**Solutions:**

1. **Verify condition target:**
   ```php
   use Daikazu\Flexicart\Enums\ConditionTarget;

   // For cart-wide discounts
   $condition = new PercentageCondition(
       name: 'Discount',
       value: -10,
       target: ConditionTarget::SUBTOTAL  // Not ITEM
   );
   ```

2. **Check condition order:**
   ```php
   // Lower order numbers are applied first
   $firstDiscount = new PercentageCondition(
       name: 'First',
       value: -5,
       order: 1  // Applied first
   );

   $secondDiscount = new PercentageCondition(
       name: 'Second',
       value: -10,
       order: 2  // Applied second
   );
   ```

3. **Ensure values are properly signed:**
   ```php
   // Negative for discounts
   $discount = new PercentageCondition(
       name: 'Discount',
       value: -10  // Negative = discount
   );

   // Positive for fees
   $fee = new FixedCondition(
       name: 'Shipping',
       value: 5.99  // Positive = fee
   );
   ```

4. **Verify taxable targeting:**
   ```php
   // If targeting taxable items, ensure items are marked as taxable
   Cart::addItem([
       'id' => 1,
       'name' => 'Product',
       'price' => 100,
       'taxable' => true,  // Required for TAXABLE target
   ]);
   ```

### Memory Issues with Large Carts

**Symptoms:** Slow performance, memory exhaustion errors.

**Solutions:**

1. **Use database storage:**
   ```env
   CART_STORAGE=database
   ```

2. **Implement cart item limits:**
   ```php
   // In your controller
   public function addToCart(Request $request)
   {
       if (Cart::uniqueCount() >= 100) {
           return back()->with('error', 'Cart is full');
       }

       Cart::addItem($request->validated());
   }
   ```

3. **Configure cart cleanup:**
   ```php
   // config/flexicart.php
   'cleanup' => [
       'enabled' => true,
       'lifetime' => 60 * 24 * 7,  // 1 week
   ],
   ```

4. **Schedule regular cleanup:**
   ```php
   // routes/console.php
   Schedule::command('flexicart:cleanup-carts')->daily();
   ```

### Rules Not Applying

**Symptoms:** Promotional rules don't affect the total.

**Solutions:**

1. **Ensure rule conditions are met:**
   ```php
   // ThresholdRule requires minimum subtotal
   $rule = new ThresholdRule(
       name: 'Spend $100 Save 10%',
       minSubtotal: 100.00,  // Cart must have $100+ subtotal
       discount: -10.0,
       discountType: ConditionType::PERCENTAGE
   );

   // Check if cart meets threshold
   if (Cart::subtotal()->toFloat() < 100) {
       // Rule won't apply
   }
   ```

2. **Verify item ID patterns match:**
   ```php
   // Pattern must match item IDs
   $rule = new BuyXGetYRule(
       name: 'Buy 2 Get 1 Free',
       buyQuantity: 2,
       getQuantity: 1,
       getDiscount: 100.0,
       itemIds: ['shirt-*']  // Must match item IDs like 'shirt-blue'
   );

   // These would match:
   Cart::addItem(['id' => 'shirt-blue', ...]);
   Cart::addItem(['id' => 'shirt-red', ...]);

   // This would NOT match:
   Cart::addItem(['id' => 'pants-blue', ...]);
   ```

## Exception Handling

FlexiCart throws specific exceptions that you can catch and handle:

### CartException

Thrown for cart-specific errors like invalid operations or missing data.

```php
use Daikazu\Flexicart\Exceptions\CartException;

try {
    Cart::addItem([
        'name' => 'Product',
        'price' => 10.00,
        // Missing required 'id' field
    ]);
} catch (CartException $e) {
    Log::error('Cart error: ' . $e->getMessage());
    return back()->with('error', 'Unable to add item to cart');
}
```

### PriceException

Thrown for price calculation errors.

```php
use Daikazu\Flexicart\Exceptions\PriceException;

try {
    $price = Price::from('invalid');
} catch (PriceException $e) {
    Log::error('Price error: ' . $e->getMessage());
    return back()->with('error', 'Invalid price format');
}
```

### Global Exception Handling

Add to your exception handler for application-wide handling:

```php
// app/Exceptions/Handler.php or bootstrap/app.php (Laravel 11+)
use Daikazu\Flexicart\Exceptions\CartException;
use Daikazu\Flexicart\Exceptions\PriceException;

->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (CartException $e) {
        return response()->json([
            'error' => 'Cart operation failed',
            'message' => $e->getMessage(),
        ], 400);
    });

    $exceptions->render(function (PriceException $e) {
        return response()->json([
            'error' => 'Price calculation error',
            'message' => $e->getMessage(),
        ], 400);
    });
});
```

## Debugging Tips

### Inspect Cart State

```php
// Get all cart data for debugging
$data = Cart::getRawCartData();
dd($data);

// Check specific values
dump('Items:', Cart::items());
dump('Conditions:', Cart::conditions());
dump('Rules:', Cart::rules());
dump('Subtotal:', Cart::subtotal()->formatted());
dump('Total:', Cart::total()->formatted());
```

### Enable Event Debugging

```php
// In a service provider or test
use Daikazu\Flexicart\Events\ItemAdded;
use Illuminate\Support\Facades\Event;

Event::listen('*', function ($eventName, array $data) {
    if (str_starts_with($eventName, 'Daikazu\\Flexicart\\Events')) {
        Log::debug("Cart Event: {$eventName}", $data);
    }
});
```

### Check Configuration

```php
// Verify configuration is loaded correctly
dump(config('flexicart'));

// Check specific settings
dump('Storage:', config('flexicart.storage'));
dump('Currency:', config('flexicart.currency'));
dump('Compound Discounts:', config('flexicart.compound_discounts'));
```

## Getting Help

If you're still experiencing issues:

1. Check the [GitHub Issues](https://github.com/daikazu/flexicart/issues) for similar problems
2. Review the test suite for usage examples
3. Enable Laravel's debug mode to see detailed error messages
4. Use `dd()` or `dump()` to inspect cart state at various points
