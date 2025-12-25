<?php

namespace App\Livewire;

use Daikazu\Flexicart\CartItem;
use Daikazu\Flexicart\Facades\Cart;
use Daikazu\Flexicart\Price;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CartDrawer extends Component
{
    public bool $open = false;

    #[On('open-cart-drawer')]
    public function openDrawer(): void
    {
        $this->open = true;
    }

    public function closeDrawer(): void
    {
        $this->open = false;
    }

    /** @return Collection<string, CartItem> */
    #[Computed]
    public function items(): Collection
    {
        return Cart::items();
    }

    #[Computed]
    public function count(): int
    {
        return Cart::count();
    }

    #[Computed]
    public function subtotal(): Price
    {
        return Cart::subtotal();
    }

    #[Computed]
    public function total(): Price
    {
        return Cart::total();
    }

    public function updateQuantity(string $itemId, int $quantity): void
    {
        if ($quantity <= 0) {
            Cart::removeItem($itemId);
        } else {
            Cart::updateItem($itemId, ['quantity' => $quantity]);
        }

        unset($this->items, $this->count, $this->subtotal, $this->total);
        $this->dispatch('cart-updated');
    }

    public function removeItem(string $itemId): void
    {
        Cart::removeItem($itemId);
        unset($this->items, $this->count, $this->subtotal, $this->total);
        $this->dispatch('cart-updated');
    }

    public function clearCart(): void
    {
        Cart::clear();
        unset($this->items, $this->count, $this->subtotal, $this->total);
        $this->dispatch('cart-updated');
    }

    public function render(): mixed
    {
        return view('livewire.cart-drawer');
    }
}
