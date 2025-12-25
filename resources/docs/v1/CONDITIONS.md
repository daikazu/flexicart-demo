# Conditions

Conditions are adjustments that can be applied to cart items or the entire cart. They enable discounts, fees, taxes, and other price modifications.

## Understanding Conditions

FlexiCart supports several types of conditions:

- **Percentage Conditions**: Apply percentage-based adjustments (e.g., 10% discount)
- **Fixed Conditions**: Apply fixed-amount adjustments (e.g., $5 off, $2.99 shipping)
- **Tax Conditions**: Special conditions for tax calculations on taxable items

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

## Next Steps

- Explore the [Rules Engine](/docs?section=rules-engine) for advanced conditional logic
- Learn about [Configuration](/docs?section=configuration) options for compound discounts
- See [Extending FlexiCart](/docs?section=extending) to create custom condition types
