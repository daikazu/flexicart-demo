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
$item->unitPrice();   // Price per unit
$item->subtotal();    // Total for this item (price × quantity + conditions)
```

## Next Steps

- Learn about [Conditions](/docs?section=conditions) to apply discounts and fees
- Explore the [Rules Engine](/docs?section=rules-engine) for advanced promotions
- See [Configuration](/docs?section=configuration) for storage and currency options
