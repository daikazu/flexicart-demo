# Installation

## Requirements

- PHP 8.3 or higher
- Laravel 11.0 or higher
- Brick/Money package (automatically installed)

## Install the Package

```bash
composer require daikazu/flexicart
```

## Publish Configuration

```bash
php artisan vendor:publish --tag="flexicart-config"
```

## Database Storage (Optional)

If you prefer database storage over session storage:

```bash
php artisan vendor:publish --tag="flexicart-migrations"
php artisan migrate
```

Then update your `.env` file:

```env
CART_STORAGE=database
```

## Next Steps

Once installed, you can start using the Cart facade to add items:

```php
use Daikazu\Flexicart\Facades\Cart;

Cart::addItem([
    'id' => 1,
    'name' => 'Product Name',
    'price' => 29.99,
    'quantity' => 1
]);
```

See the [Basic Usage](/docs?section=basic-usage) section for more details.
