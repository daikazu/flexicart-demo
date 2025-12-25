<?php

namespace App\Livewire;

use App\Models\Product;
use Daikazu\Flexicart\Facades\Cart;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductCatalog extends Component
{
    public string $selectedCategory = '';

    /** @var array<int, string> */
    public array $selectedColors = [];

    /** @var array<int, string> */
    public array $selectedSizes = [];

    /** @return Collection<int, Product> */
    #[Computed]
    public function products(): Collection
    {
        $query = Product::query()->where('active', true);

        if ($this->selectedCategory) {
            $query->where('category', $this->selectedCategory);
        }

        return $query->orderBy('name')->get();
    }

    /** @return array<string> */
    #[Computed]
    public function categories(): array
    {
        return Product::query()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values()
            ->toArray();
    }

    public function addToCart(int $productId): void
    {
        $product = Product::find($productId);

        if (! $product) {
            return;
        }

        $attributes = [];

        if (isset($this->selectedColors[$productId])) {
            $attributes['color'] = $this->selectedColors[$productId];
        }

        if (isset($this->selectedSizes[$productId])) {
            $attributes['size'] = $this->selectedSizes[$productId];
        }

        Cart::addItem([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'taxable' => $product->taxable,
            'attributes' => $attributes,
        ]);

        $this->selectedColors[$productId] = '';
        $this->selectedSizes[$productId] = '';

        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-drawer');
    }

    public function render(): mixed
    {
        return view('livewire.product-catalog');
    }
}
