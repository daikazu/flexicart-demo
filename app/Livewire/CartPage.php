<?php

namespace App\Livewire;

use Daikazu\Flexicart\Conditions\Contracts\ConditionInterface;
use Daikazu\Flexicart\Conditions\Rules\BuyXGetYRule;
use Daikazu\Flexicart\Conditions\Rules\ThresholdRule;
use Daikazu\Flexicart\Conditions\Rules\TieredRule;
use Daikazu\Flexicart\Conditions\Types\FixedCondition;
use Daikazu\Flexicart\Conditions\Types\PercentageCondition;
use Daikazu\Flexicart\Enums\ConditionTarget;
use Daikazu\Flexicart\Enums\ConditionType;
use Daikazu\Flexicart\Facades\Cart;
use Daikazu\Flexicart\Price;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CartPage extends Component
{
    public string $couponCode = '';

    public string $couponMessage = '';

    public string $couponMessageType = '';

    public function mount(): void
    {
        //
    }

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
    public function uniqueCount(): int
    {
        return Cart::uniqueCount();
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

    #[Computed]
    public function taxableSubtotal(): Price
    {
        return Cart::getTaxableSubtotal();
    }

    #[Computed]
    public function conditions(): Collection
    {
        return Cart::conditions();
    }

    #[Computed]
    public function rules(): Collection
    {
        return Cart::rules();
    }

    #[Computed]
    public function isEmpty(): bool
    {
        return Cart::isEmpty();
    }

    public function updateQuantity(string $itemId, int $quantity): void
    {
        if ($quantity <= 0) {
            Cart::removeItem($itemId);
        } else {
            Cart::updateItem($itemId, ['quantity' => $quantity]);
        }
        $this->dispatch('cart-updated');
    }

    public function removeItem(string $itemId): void
    {
        Cart::removeItem($itemId);
        $this->dispatch('cart-updated');
    }

    public function clearCart(): void
    {
        Cart::reset();
        $this->dispatch('cart-updated');
    }

    public function applyCoupon(): void
    {
        $code = strtoupper(trim($this->couponCode));

        $existingCondition = Cart::conditions()->first(
            fn (ConditionInterface $c): bool => $c->name === $code
        );

        if ($existingCondition) {
            $this->couponMessage = 'This coupon is already applied.';
            $this->couponMessageType = 'error';

            return;
        }

        $condition = match ($code) {
            'SAVE10' => new PercentageCondition(
                name: 'SAVE10',
                value: -10,
                target: ConditionTarget::SUBTOTAL
            ),
            'FLAT20' => new FixedCondition(
                name: 'FLAT20',
                value: -20,
                target: ConditionTarget::SUBTOTAL
            ),
            'SUMMER25' => new PercentageCondition(
                name: 'SUMMER25',
                value: -25,
                target: ConditionTarget::SUBTOTAL
            ),
            default => null,
        };

        if ($condition) {
            Cart::addCondition($condition);
            $this->couponCode = '';
            $this->couponMessage = "Coupon '{$code}' applied successfully!";
            $this->couponMessageType = 'success';
            $this->dispatch('cart-updated');
        } else {
            $this->couponMessage = 'Invalid coupon code.';
            $this->couponMessageType = 'error';
        }
    }

    public function removeCondition(string $name): void
    {
        Cart::removeCondition($name);
        $this->dispatch('cart-updated');
    }

    public function addShipping(): void
    {
        $shipping = new FixedCondition(
            name: 'Standard Shipping',
            value: 5.99,
            target: ConditionTarget::SUBTOTAL
        );
        Cart::addCondition($shipping);
        $this->dispatch('cart-updated');
    }

    public function addTax(): void
    {
        $tax = new PercentageCondition(
            name: 'Sales Tax (8%)',
            value: 8,
            target: ConditionTarget::TAXABLE,
            taxable: true
        );
        Cart::addCondition($tax);
        $this->dispatch('cart-updated');
    }

    public function addBuyXGetYRule(): void
    {
        $rule = new BuyXGetYRule(
            name: 'Buy 2 Get 1 Free',
            buyQuantity: 2,
            getQuantity: 1,
            getDiscount: 100.0
        );
        Cart::addRule($rule);
        $this->dispatch('cart-updated');
    }

    public function addThresholdRule(): void
    {
        $rule = new ThresholdRule(
            name: 'Spend $100 Save 10%',
            minSubtotal: 100.00,
            discount: -10.0,
            discountType: ConditionType::PERCENTAGE
        );
        Cart::addRule($rule);
        $this->dispatch('cart-updated');
    }

    public function addTieredRule(): void
    {
        $rule = new TieredRule(
            name: 'Volume Discount',
            tiers: [
                50 => 5,
                100 => 10,
                200 => 15,
            ]
        );
        Cart::addRule($rule);
        $this->dispatch('cart-updated');
    }

    public function removeRule(string $name): void
    {
        Cart::removeRule($name);
        $this->dispatch('cart-updated');
    }

    public function clearRules(): void
    {
        Cart::clearRules();
        $this->dispatch('cart-updated');
    }

    public function addItemCondition(string $itemId, string $type): void
    {
        $condition = match ($type) {
            'discount' => new PercentageCondition(
                name: 'Item Discount 15%',
                value: -15,
                target: ConditionTarget::ITEM
            ),
            'premium' => new FixedCondition(
                name: 'Premium Add-on',
                value: 5.00,
                target: ConditionTarget::ITEM
            ),
            default => null,
        };

        if ($condition) {
            Cart::addItemCondition($itemId, $condition);
            $this->dispatch('cart-updated');
        }
    }

    public function removeItemCondition(string $itemId, string $conditionName): void
    {
        Cart::removeItemCondition($itemId, $conditionName);
        $this->dispatch('cart-updated');
    }

    public function toggleTaxable(string $itemId): void
    {
        $item = Cart::item($itemId);
        if ($item) {
            Cart::updateItem($itemId, ['taxable' => ! $item->taxable]);
            $this->dispatch('cart-updated');
        }
    }

    public function render(): mixed
    {
        return view('livewire.cart-page');
    }
}
