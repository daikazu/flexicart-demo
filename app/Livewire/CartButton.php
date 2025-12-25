<?php

namespace App\Livewire;

use Daikazu\Flexicart\Facades\Cart;
use Livewire\Attributes\On;
use Livewire\Component;

class CartButton extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount(): void
    {
        $this->count = Cart::count();
    }

    public function openDrawer(): void
    {
        $this->dispatch('open-cart-drawer');
    }

    public function render(): mixed
    {
        return view('livewire.cart-button');
    }
}
