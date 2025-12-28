# Extending FlexiCart

FlexiCart is designed to be extended. You can create custom conditions, storage drivers, and integrate with your existing models.

## Custom Condition Classes

Create custom condition types by extending the base `Condition` class:

```php
<?php

namespace App\Cart\Conditions;

use Daikazu\Flexicart\Conditions\Condition;
use Daikazu\Flexicart\Enums\ConditionType;
use Daikazu\Flexicart\Price;

class BuyOneGetOneCondition extends Condition
{
    public ConditionType $type = ConditionType::PERCENTAGE;

    public function calculate(?Price $price = null): Price
    {
        // Custom calculation logic
        // For example, buy one get one 50% off
        if ($this->attributes->quantity >= 2) {
            $discount = $price->multipliedBy(0.5);
            return $discount->multipliedBy(-1); // Negative for discount
        }

        return Price::from(0);
    }

    public function formattedValue(): string
    {
        return 'Buy One Get One 50% Off';
    }
}
```

### Usage

```php
use App\Cart\Conditions\BuyOneGetOneCondition;
use Daikazu\Flexicart\Enums\ConditionTarget;

$condition = new BuyOneGetOneCondition(
    name: 'BOGO Deal',
    value: 50,
    target: ConditionTarget::ITEM
);

Cart::addItemCondition('item-123', $condition);
```

## Custom Storage Drivers

Implement custom storage by creating a class that implements `StorageInterface`:

```php
<?php

namespace App\Cart\Storage;

use Daikazu\Flexicart\Contracts\StorageInterface;
use Illuminate\Support\Facades\Redis;

class RedisCartStorage implements StorageInterface
{
    protected string $prefix = 'cart:';

    public function get(string $key): array
    {
        $data = Redis::get($this->prefix . $key);

        return $data ? json_decode($data, true) : [];
    }

    public function put(string $key, array $data): void
    {
        Redis::set(
            $this->prefix . $key,
            json_encode($data),
            'EX',
            60 * 60 * 24 * 7 // 1 week TTL
        );
    }

    public function forget(string $key): void
    {
        Redis::del($this->prefix . $key);
    }

    public function flush(): void
    {
        $keys = Redis::keys($this->prefix . '*');
        if (!empty($keys)) {
            Redis::del($keys);
        }
    }
}
```

### Registering Custom Storage

Configure in `config/flexicart.php`:

```php
'storage_class' => App\Cart\Storage\RedisCartStorage::class,
```

## Custom Models

When using database storage, extend the default models:

### Custom Cart Model

```php
<?php

namespace App\Models;

use Daikazu\Flexicart\Models\Cart as BaseCart;

class Cart extends BaseCart
{
    protected $appends = ['formatted_total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return $this->total()->formatted();
    }

    // Add custom scopes
    public function scopeAbandoned($query)
    {
        return $query->where('updated_at', '<', now()->subDays(7));
    }
}
```

### Custom CartItem Model

```php
<?php

namespace App\Models;

use Daikazu\Flexicart\Models\CartItem as BaseCartItem;

class CartItem extends BaseCartItem
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->product?->image_url;
    }
}
```

### Configuration

```php
// config/flexicart.php
'cart_model' => App\Models\Cart::class,
'cart_item_model' => App\Models\CartItem::class,
```

## Custom Rules

For complex promotional logic, create custom rules. See [Rules Engine](RULES_ENGINE.md) for detailed documentation.

```php
<?php

namespace App\Cart\Rules;

use Daikazu\Flexicart\Conditions\Rules\AbstractRule;
use Daikazu\Flexicart\Enums\ConditionType;
use Daikazu\Flexicart\Price;

class FirstTimeCustomerRule extends AbstractRule
{
    public function __construct(
        string $name,
        public readonly float $discountPercent,
        public readonly bool $isFirstOrder = false
    ) {
        parent::__construct($name, $discountPercent);
        $this->type = ConditionType::PERCENTAGE;
    }

    public function applies(): bool
    {
        return $this->isFirstOrder;
    }

    public function getDiscount(): Price
    {
        if (!$this->applies()) {
            return Price::zero();
        }

        $discountAmount = $this->subtotal->multiplyBy($this->discountPercent / 100);
        return Price::from(-$discountAmount->toFloat());
    }
}
```

## Custom Merge Strategies

Create custom merge behavior by implementing `MergeStrategyInterface`:

```php
<?php

namespace App\Cart\Strategies;

use Daikazu\Flexicart\CartItem;
use Daikazu\Flexicart\Strategies\MergeStrategyInterface;
use Illuminate\Support\Collection;

class AverageMergeStrategy implements MergeStrategyInterface
{
    public function name(): string
    {
        return 'average';
    }

    public function mergeItem(CartItem $targetItem, CartItem $sourceItem): array
    {
        // Average the quantities
        $avgQuantity = (int) ceil(($targetItem->quantity + $sourceItem->quantity) / 2);

        return [
            'id' => $targetItem->id,
            'name' => $sourceItem->name,
            'price' => $sourceItem->unitPrice(),
            'quantity' => $avgQuantity,
            'taxable' => $sourceItem->taxable,
            'attributes' => $sourceItem->attributes->toArray(),
        ];
    }

    public function handleNewItem(CartItem $sourceItem): array
    {
        return [
            'id' => $sourceItem->id,
            'name' => $sourceItem->name,
            'price' => $sourceItem->unitPrice(),
            'quantity' => $sourceItem->quantity,
            'taxable' => $sourceItem->taxable,
            'attributes' => $sourceItem->attributes->toArray(),
        ];
    }

    public function mergeConditions(Collection $targetConditions, Collection $sourceConditions): Collection
    {
        return $targetConditions->merge($sourceConditions);
    }
}
```

### Register the Strategy

```php
use Daikazu\Flexicart\Strategies\MergeStrategyFactory;
use App\Cart\Strategies\AverageMergeStrategy;

// In a service provider
MergeStrategyFactory::register('average', AverageMergeStrategy::class);

// Usage
$cart->mergeFrom($sourceCart, 'average');
```

## Event Listeners

Hook into cart lifecycle events for analytics, inventory, notifications, etc. See [Events](EVENTS.md) for complete documentation.

```php
// app/Providers/EventServiceProvider.php
use Daikazu\Flexicart\Events\ItemAdded;
use Daikazu\Flexicart\Events\CartCleared;

protected $listen = [
    ItemAdded::class => [
        App\Listeners\ReserveInventory::class,
        App\Listeners\TrackAddToCart::class,
    ],
    CartCleared::class => [
        App\Listeners\ReleaseInventory::class,
    ],
];
```

## Service Container Bindings

Override FlexiCart services via the container:

```php
// app/Providers/AppServiceProvider.php
use Daikazu\Flexicart\Contracts\StorageInterface;
use App\Cart\Storage\RedisCartStorage;

public function register()
{
    $this->app->bind(StorageInterface::class, RedisCartStorage::class);
}
```

## Macros

Add methods to the Cart class at runtime:

```php
use Daikazu\Flexicart\Cart;

// In a service provider
Cart::macro('hasPromoCode', function () {
    return $this->conditions()->contains(fn ($c) => str_starts_with($c->name, 'PROMO:'));
});

// Usage
if (Cart::hasPromoCode()) {
    // ...
}
```

## Testing FlexiCart

### Testing Custom Extensions

```php
use Daikazu\Flexicart\Facades\Cart;
use App\Cart\Conditions\BuyOneGetOneCondition;

test('bogo condition applies correctly', function () {
    Cart::addItem([
        'id' => 'shirt-1',
        'name' => 'T-Shirt',
        'price' => 20.00,
        'quantity' => 2,
    ]);

    $item = Cart::item('shirt-1');
    Cart::addItemCondition('shirt-1', new BuyOneGetOneCondition(
        name: 'BOGO',
        value: 50
    ));

    // With BOGO 50% off on 2 items ($40 total), discount should be $10
    expect($item->total()->toFloat())->toBe(30.00);
});
```

### Resetting the Cart Between Tests

Always reset the cart between tests to ensure a clean state:

```php
use Daikazu\Flexicart\Facades\Cart;

beforeEach(function () {
    Cart::reset();
});

test('cart starts empty', function () {
    expect(Cart::isEmpty())->toBeTrue();
    expect(Cart::count())->toBe(0);
});
```

### Testing Cart Operations

```php
use Daikazu\Flexicart\Facades\Cart;

test('can add items to cart', function () {
    Cart::addItem([
        'id' => 'product-1',
        'name' => 'Test Product',
        'price' => 25.00,
        'quantity' => 2,
    ]);

    expect(Cart::count())->toBe(2);
    expect(Cart::uniqueCount())->toBe(1);
    expect(Cart::subtotal()->toFloat())->toBe(50.00);
});

test('can update item quantity', function () {
    Cart::addItem([
        'id' => 'product-1',
        'name' => 'Test Product',
        'price' => 25.00,
        'quantity' => 1,
    ]);

    Cart::updateItem('product-1', ['quantity' => 5]);

    expect(Cart::count())->toBe(5);
});

test('can apply discount condition', function () {
    Cart::addItem([
        'id' => 'product-1',
        'name' => 'Test Product',
        'price' => 100.00,
        'quantity' => 1,
    ]);

    Cart::addCondition(new PercentageCondition(
        name: '10% Off',
        value: -10,
        target: ConditionTarget::SUBTOTAL
    ));

    expect(Cart::total()->toFloat())->toBe(90.00);
});
```

### Testing with Events

```php
use Daikazu\Flexicart\Facades\Cart;
use Daikazu\Flexicart\Events\ItemAdded;
use Illuminate\Support\Facades\Event;

test('dispatches event when item is added', function () {
    Event::fake([ItemAdded::class]);

    Cart::addItem([
        'id' => 'product-1',
        'name' => 'Test Product',
        'price' => 25.00,
    ]);

    Event::assertDispatched(ItemAdded::class, function ($event) {
        return $event->item->id === 'product-1';
    });
});
```

### Testing Rules

```php
use Daikazu\Flexicart\Facades\Cart;
use Daikazu\Flexicart\Conditions\Rules\ThresholdRule;
use Daikazu\Flexicart\Enums\ConditionType;

test('threshold rule applies when subtotal met', function () {
    Cart::addItem([
        'id' => 'product-1',
        'name' => 'Expensive Item',
        'price' => 150.00,
        'quantity' => 1,
    ]);

    Cart::addRule(new ThresholdRule(
        name: 'Spend $100 Save 10%',
        minSubtotal: 100.00,
        discount: -10.0,
        discountType: ConditionType::PERCENTAGE
    ));

    // $150 - 10% = $135
    expect(Cart::total()->toFloat())->toBe(135.00);
});

test('threshold rule does not apply when subtotal not met', function () {
    Cart::addItem([
        'id' => 'product-1',
        'name' => 'Cheap Item',
        'price' => 50.00,
        'quantity' => 1,
    ]);

    Cart::addRule(new ThresholdRule(
        name: 'Spend $100 Save 10%',
        minSubtotal: 100.00,
        discount: -10.0,
        discountType: ConditionType::PERCENTAGE
    ));

    // Rule doesn't apply, still $50
    expect(Cart::total()->toFloat())->toBe(50.00);
});
```

### Mocking the Cart Facade

For unit testing code that uses the Cart:

```php
use Daikazu\Flexicart\Facades\Cart;
use Daikazu\Flexicart\Price;

test('checkout calculates correct total', function () {
    Cart::shouldReceive('total')
        ->once()
        ->andReturn(Price::from(99.99));

    Cart::shouldReceive('items')
        ->once()
        ->andReturn(collect());

    // Test your checkout logic here
    $checkout = new CheckoutService();
    expect($checkout->getTotal())->toBe(99.99);
});
```
