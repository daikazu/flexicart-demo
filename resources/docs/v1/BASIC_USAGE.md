# Basic Usage

FlexiCart provides a simple, fluent API for managing shopping cart operations. All interactions go through the `Cart` facade.

## Adding Items to the Cart

```php
use Daikazu\Flexicart\Facades\Cart;

// Add a single item
Cart::addItem([
    'id' => 1,
    'name' => 'Product Name',
    'price' => 29.99,
    'quantity' => 2,
    'attributes' => [
        'color' => 'red',
        'size' => 'large'
    ]
]);

// Add multiple items at once
Cart::addItem([
    [
        'id' => 2,
        'name' => 'Another Product',
        'price' => 15.50,
        'quantity' => 1
    ],
    [
        'id' => 3,
        'name' => 'Third Product',
        'price' => 45.00,
        'quantity' => 3
    ]
]);
```

### Item Properties

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `id` | string\|int | Yes | Unique identifier for the item |
| `name` | string | Yes | Display name of the item |
| `price` | float | Yes | Unit price of the item |
| `quantity` | int | No | Quantity to add (default: 1) |
| `attributes` | array | No | Custom attributes (color, size, etc.) |
| `taxable` | bool | No | Whether item is taxable (default: true) |

## Updating Items in the Cart

```php
// Update quantity
Cart::updateItem('item_id', ['quantity' => 5]);

// Update attributes
Cart::updateItem('item_id', [
    'attributes' => [
        'color' => 'blue',
        'size' => 'medium'
    ]
]);

// Update multiple properties at once
Cart::updateItem('item_id', [
    'quantity' => 3,
    'price' => 25.99,
    'attributes' => ['color' => 'green']
]);
```

## Removing Items from the Cart

```php
// Remove a specific item
Cart::removeItem('item_id');

// Clear all items from the cart (keeps conditions)
Cart::clear();

// Clear all items AND conditions from cart
Cart::reset();
```

## Getting Cart Content and Calculations

```php
// Get all items as a Collection
$items = Cart::items();

// Get a specific item by ID
$item = Cart::item('item_id');

// Get cart counts
$totalItems = Cart::count();        // Total quantity of all items
$uniqueItems = Cart::uniqueCount(); // Number of unique items

// Check if cart is empty
$isEmpty = Cart::isEmpty();

// Get the cart ID
$cartId = Cart::id();

// Get cart totals (returns Price objects)
$subtotal = Cart::subtotal();              // Subtotal before conditions
$total = Cart::total();                     // Final total after all conditions
$taxableSubtotal = Cart::getTaxableSubtotal(); // Subtotal of taxable items only
```

## Working with Cart Items

Each cart item is a `CartItem` object with the following properties:

```php
$item = Cart::item('item_id');

$item->id;          // Item identifier
$item->name;        // Item name
$item->price;       // Unit price (Price object)
$item->quantity;    // Current quantity
$item->attributes;  // Fluent object with custom attributes
$item->taxable;     // Whether item is taxable
$item->conditions;  // Collection of item conditions

// Get calculated values
$item->unitPrice();            // Price per unit
$item->subtotal();             // Total for this item (price × quantity + conditions)
$item->unadjustedSubtotal();   // Total before conditions (price × quantity)
```

### CartItem Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `unitPrice()` | Price | The base price per unit |
| `subtotal()` | Price | Total after applying item conditions |
| `unadjustedSubtotal()` | Price | Total before conditions (price × quantity) |
| `setQuantity(int)` | self | Set the item quantity directly |
| `addCondition($condition)` | self | Add a condition to the item |
| `addConditions(array)` | self | Add multiple conditions at once |
| `removeCondition(string)` | self | Remove a condition by name |
| `clearConditions()` | self | Remove all conditions from the item |
| `toArray()` | array | Convert the item to an array |

### Creating CartItem Objects

You can create CartItem objects directly using the factory method:

```php
use Daikazu\Flexicart\CartItem;

$item = CartItem::make([
    'id' => 'product-123',
    'name' => 'Premium Widget',
    'price' => 49.99,
    'quantity' => 2,
    'attributes' => ['color' => 'blue'],
    'taxable' => true,
]);

Cart::addItem($item);
```

### Converting Items to Arrays

Useful for APIs or serialization:

```php
$item = Cart::item('product-123');
$data = $item->toArray();

// Returns:
// [
//     'id' => 'product-123',
//     'name' => 'Premium Widget',
//     'price' => Price object,
//     'quantity' => 2,
//     'unitPrice' => Price object,
//     'subtotal' => Price object,
//     'attributes' => ['color' => 'blue'],
//     'conditions' => [],
// ]
```

## Next Steps

- Learn about [Conditions](/docs?section=conditions) to apply discounts and fees
- Explore the [Rules Engine](/docs?section=rules-engine) for advanced promotions
- See [Configuration](/docs?section=configuration) for storage and currency options
