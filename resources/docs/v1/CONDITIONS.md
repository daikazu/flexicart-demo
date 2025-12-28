# Conditions

Conditions are adjustments that can be applied to cart items or the entire cart. They enable discounts, fees, taxes, and other price modifications.

## Understanding Conditions

FlexiCart supports several types of conditions:

- **Percentage Conditions**: Apply percentage-based adjustments (e.g., 10% discount)
- **Fixed Conditions**: Apply fixed-amount adjustments (e.g., $5 off, $2.99 shipping)
- **Percentage Tax Conditions**: Percentage-based tax calculations on taxable items
- **Fixed Tax Conditions**: Fixed-amount tax applied to taxable items

### Condition Targets

Conditions can target different parts of the cart:

| Target | Description |
|--------|-------------|
| `ITEM` | Applied to a specific cart item |
| `SUBTOTAL` | Applied to the entire cart subtotal |
| `TAXABLE` | Applied only to items marked as taxable |

## Adding Cart Conditions

```php
use Daikazu\Flexicart\Conditions\Types\PercentageCondition;
use Daikazu\Flexicart\Conditions\Types\FixedCondition;
use Daikazu\Flexicart\Enums\ConditionTarget;

// Add a 10% discount to the cart
$discount = new PercentageCondition(
    name: '10% Off Sale',
    value: -10, // Negative for discount
    target: ConditionTarget::SUBTOTAL
);
Cart::addCondition($discount);

// Add a $5 shipping fee
$shipping = new FixedCondition(
    name: 'Shipping Fee',
    value: 5.00,
    target: ConditionTarget::SUBTOTAL
);
Cart::addCondition($shipping);

// Add 8% tax on taxable items only
$tax = new PercentageCondition(
    name: 'Sales Tax',
    value: 8,
    target: ConditionTarget::TAXABLE
);
Cart::addCondition($tax);
```

## Adding Item Conditions

Apply conditions directly to specific items:

```php
// Add 20% discount to a specific item
$itemDiscount = new PercentageCondition(
    name: 'Item Discount',
    value: -20,
    target: ConditionTarget::ITEM
);
Cart::addItemCondition('item_id', $itemDiscount);

// Add a $5 premium add-on fee
$addon = new FixedCondition(
    name: 'Premium Add-on',
    value: 5.00,
    target: ConditionTarget::ITEM
);
Cart::addItemCondition('item_id', $addon);
```

## Removing Conditions

```php
// Remove a specific condition from the cart
Cart::removeCondition('10% Off Sale');

// Remove a condition from a specific item
Cart::removeItemCondition('item_id', 'Item Discount');

// Clear all cart conditions
Cart::clearConditions();
```

## Marking Items as Non-Taxable

Some items like gift cards or services may be tax-exempt:

```php
// Add a non-taxable item
Cart::addItem([
    'id' => 4,
    'name' => 'Gift Card',
    'price' => 50.00,
    'quantity' => 1,
    'taxable' => false
]);

// Update existing item to be non-taxable
Cart::updateItem('item_id', ['taxable' => false]);
```

## Tax Conditions

FlexiCart provides dedicated tax condition classes that automatically target taxable items:

### PercentageTaxCondition

Apply percentage-based tax to taxable items only:

```php
use Daikazu\Flexicart\Conditions\Types\PercentageTaxCondition;

// Add 8.25% sales tax
$salesTax = new PercentageTaxCondition(
    name: 'Sales Tax',
    value: 8.25
);
Cart::addCondition($salesTax);

// Add 5% state tax
$stateTax = new PercentageTaxCondition(
    name: 'State Tax',
    value: 5.0
);
Cart::addCondition($stateTax);
```

### FixedTaxCondition

Apply a fixed tax amount:

```php
use Daikazu\Flexicart\Conditions\Types\FixedTaxCondition;

// Add a flat $2.50 environmental fee
$envFee = new FixedTaxCondition(
    name: 'Environmental Fee',
    value: 2.50
);
Cart::addCondition($envFee);
```

> **Note:** Tax conditions automatically target `ConditionTarget::TAXABLE`, so you don't need to specify the target.

## Condition Order

When multiple conditions are applied, they are processed in order. You can control the order using the `order` parameter:

```php
// This discount will be applied first
$firstDiscount = new PercentageCondition(
    name: 'Early Bird',
    value: -5,
    target: ConditionTarget::SUBTOTAL,
    order: 1
);

// This discount will be applied second
$secondDiscount = new PercentageCondition(
    name: 'Member Discount',
    value: -10,
    target: ConditionTarget::SUBTOTAL,
    order: 2
);
```

## Getting Applied Conditions

```php
// Get all cart conditions
$conditions = Cart::conditions();

// Get conditions for a specific item
$item = Cart::item('item_id');
$itemConditions = $item->conditions;
```

## Condition Properties

When creating conditions, you can specify additional properties:

```php
use Daikazu\Flexicart\Conditions\Types\PercentageCondition;
use Daikazu\Flexicart\Enums\ConditionTarget;

$condition = new PercentageCondition(
    name: 'VIP Discount',         // Required: unique identifier
    value: -15,                    // Required: adjustment value
    target: ConditionTarget::SUBTOTAL, // Where to apply
    attributes: [                  // Optional: custom metadata
        'code' => 'VIP2024',
        'expires_at' => '2024-12-31',
    ],
    order: 1,                      // Optional: processing order (default: 0)
    taxable: true                  // Optional: affects taxable subtotal (default: false)
);
```

### Property Reference

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `name` | string | required | Unique identifier for the condition |
| `value` | int\|float | required | The adjustment value (negative for discounts) |
| `target` | ConditionTarget | SUBTOTAL | Where to apply: ITEM, SUBTOTAL, or TAXABLE |
| `attributes` | array | [] | Custom metadata stored with the condition |
| `order` | int | 0 | Processing order (lower numbers first) |
| `taxable` | bool | false | When true, the condition affects taxable calculations |

### Creating Conditions from Arrays

You can create conditions from arrays using the factory method:

```php
use Daikazu\Flexicart\Conditions\Types\FixedCondition;
use Daikazu\Flexicart\Enums\ConditionTarget;

$condition = FixedCondition::make([
    'name' => 'Shipping',
    'value' => 5.99,
    'target' => ConditionTarget::SUBTOTAL,
    'attributes' => ['carrier' => 'USPS'],
]);
```

## Adding Multiple Conditions

Add multiple conditions at once:

```php
Cart::addConditions([
    new PercentageCondition(
        name: 'Member Discount',
        value: -10,
        target: ConditionTarget::SUBTOTAL
    ),
    new FixedCondition(
        name: 'Shipping',
        value: 5.99,
        target: ConditionTarget::SUBTOTAL
    ),
]);
```

## Clearing Item Conditions

Remove all conditions from a specific item:

```php
$item = Cart::item('item_id');
$item->clearConditions();

// Don't forget to persist the change
Cart::updateItem('item_id', []);
```

## Next Steps

- Explore the [Rules Engine](/docs?section=rules-engine) for advanced conditional logic
- Learn about [Configuration](/docs?section=configuration) options for compound discounts
- See [Extending FlexiCart](/docs?section=extending) to create custom condition types
