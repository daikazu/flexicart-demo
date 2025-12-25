<div class="py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Shopping Cart</h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                Explore all FlexiCart features: conditions, rules engine, item conditions, and more.
            </p>
        </div>

        @if ($this->isEmpty)
            <!-- Empty Cart -->
            <div class="rounded-2xl border border-gray-200 bg-white p-12 text-center dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="mb-2 text-xl font-semibold text-gray-900 dark:text-gray-100">Your cart is empty</h2>
                <p class="mb-6 text-gray-500 dark:text-gray-400">Add some products to explore FlexiCart features!</p>
                <a href="/" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-3 text-sm font-medium text-white shadow-lg shadow-indigo-500/25 transition-all hover:bg-indigo-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <!-- Stats -->
                    <div class="mb-6 grid grid-cols-3 gap-4">
                        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-800/50">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Total Items</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $this->count }}</div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-800/50">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Unique Items</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $this->uniqueCount }}</div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-800/50">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Taxable Total</div>
                            <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $this->taxableSubtotal->format() }}</div>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="space-y-4">
                        @foreach ($this->items as $item)
                            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50" wire:key="cart-item-{{ $item->id }}">
                                <div class="flex gap-6">
                                    <!-- Image -->
                                    <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>

                                    <!-- Details -->
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $item->name }}</h3>
                                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                                    @if (!empty($item->attributes->toArray()))
                                                        @foreach ($item->attributes->toArray() as $key => $value)
                                                            <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                                {{ ucfirst($key) }}: {{ $value }}
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                    <button
                                                        wire:click="toggleTaxable('{{ $item->id }}')"
                                                        class="rounded px-2 py-0.5 text-xs font-medium transition-colors {{ $item->taxable ? 'bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900/50 dark:text-blue-300' : 'bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/50 dark:text-green-300' }}"
                                                    >
                                                        {{ $item->taxable ? 'Taxable' : 'Tax Free' }}
                                                    </button>
                                                </div>
                                            </div>
                                            <button
                                                wire:click="removeItem('{{ $item->id }}')"
                                                class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-red-500 dark:hover:bg-gray-700"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Item Conditions -->
                                        @if ($item->conditions->isNotEmpty())
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                @foreach ($item->conditions as $condition)
                                                    <div class="flex items-center gap-1 rounded-full bg-purple-100 px-2.5 py-1 text-xs font-medium text-purple-700 dark:bg-purple-900/50 dark:text-purple-300">
                                                        <span>{{ $condition->name }}</span>
                                                        <button
                                                            wire:click="removeItemCondition('{{ $item->id }}', '{{ $condition->name }}')"
                                                            class="ml-1 rounded-full p-0.5 hover:bg-purple-200 dark:hover:bg-purple-800"
                                                        >
                                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Add Item Condition Buttons -->
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <button
                                                wire:click="addItemCondition('{{ $item->id }}', 'discount')"
                                                class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                            >
                                                + 15% Item Discount
                                            </button>
                                            <button
                                                wire:click="addItemCondition('{{ $item->id }}', 'premium')"
                                                class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                            >
                                                + $5 Premium Add-on
                                            </button>
                                        </div>

                                        <!-- Quantity & Price -->
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <button
                                                    wire:click="updateQuantity('{{ $item->id }}', {{ $item->quantity - 1 }})"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                                >
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <span class="w-10 text-center font-semibold">{{ $item->quantity }}</span>
                                                <button
                                                    wire:click="updateQuantity('{{ $item->id }}', {{ $item->quantity + 1 }})"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                                >
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->unitPrice()->format() }} each</div>
                                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $item->subtotal()->format() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Clear Cart -->
                    <div class="mt-6 flex justify-end">
                        <button
                            wire:click="clearCart"
                            wire:confirm="Are you sure you want to clear the entire cart?"
                            class="flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-100 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Clear Entire Cart
                        </button>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Cart Summary -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                        <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Order Summary</h2>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                                <span class="font-medium">{{ $this->subtotal->format() }}</span>
                            </div>

                            <!-- Active Conditions -->
                            @foreach ($this->conditions as $condition)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm {{ $condition->value < 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $condition->name }}
                                        </span>
                                        <button
                                            wire:click="removeCondition('{{ $condition->name }}')"
                                            class="rounded p-0.5 text-gray-400 hover:bg-gray-100 hover:text-red-500 dark:hover:bg-gray-700"
                                        >
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="text-sm font-medium {{ $condition->value < 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-900 dark:text-gray-100' }}">
                                        @if ($condition->type->value === 'percentage')
                                            {{ $condition->value > 0 ? '+' : '' }}{{ $condition->value }}%
                                        @else
                                            {{ $condition->value > 0 ? '+' : '' }}${{ number_format(abs($condition->value), 2) }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach

                            <!-- Active Rules -->
                            @foreach ($this->rules as $rule)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-purple-600 dark:text-purple-400">{{ $rule->getName() }}</span>
                                        <button
                                            wire:click="removeRule('{{ $rule->getName() }}')"
                                            class="rounded p-0.5 text-gray-400 hover:bg-gray-100 hover:text-red-500 dark:hover:bg-gray-700"
                                        >
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="rounded bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-700 dark:bg-purple-900/50 dark:text-purple-300">Rule</span>
                                </div>
                            @endforeach

                            <div class="border-t border-gray-200 pt-3 dark:border-gray-700">
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-gray-900 dark:text-gray-100">Total</span>
                                    <span class="text-indigo-600 dark:text-indigo-400">{{ $this->total->format() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coupon Code -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">Apply Coupon</h3>
                        <form wire:submit="applyCoupon" class="flex gap-2">
                            <input
                                type="text"
                                wire:model="couponCode"
                                placeholder="Enter code..."
                                class="flex-1 rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 text-sm uppercase focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800"
                            >
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                                Apply
                            </button>
                        </form>
                        @if ($couponMessage)
                            <p class="mt-2 text-sm {{ $couponMessageType === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $couponMessage }}
                            </p>
                        @endif
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Try: SAVE10, FLAT20, SUMMER25</p>
                    </div>

                    <!-- Quick Actions: Conditions -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">Cart Conditions</h3>
                        <div class="space-y-2">
                            <button
                                wire:click="addShipping"
                                class="flex w-full items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm transition-colors hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                            >
                                <span class="font-medium">Add Shipping (+$5.99)</span>
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>
                            <button
                                wire:click="addTax"
                                class="flex w-full items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm transition-colors hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                            >
                                <span class="font-medium">Add 8% Tax (Taxable Only)</span>
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Actions: Rules -->
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">Rules Engine</h3>
                        <p class="mb-4 text-xs text-gray-500 dark:text-gray-400">
                            Rules are smart conditions that apply based on cart context.
                        </p>
                        <div class="space-y-2">
                            <button
                                wire:click="addBuyXGetYRule"
                                class="flex w-full items-center justify-between rounded-lg border border-purple-200 bg-purple-50 px-4 py-3 text-sm transition-colors hover:bg-purple-100 dark:border-purple-900/50 dark:bg-purple-900/20 dark:hover:bg-purple-900/30"
                            >
                                <span class="font-medium text-purple-700 dark:text-purple-300">Buy 2 Get 1 Free</span>
                                <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>
                            <button
                                wire:click="addThresholdRule"
                                class="flex w-full items-center justify-between rounded-lg border border-purple-200 bg-purple-50 px-4 py-3 text-sm transition-colors hover:bg-purple-100 dark:border-purple-900/50 dark:bg-purple-900/20 dark:hover:bg-purple-900/30"
                            >
                                <span class="font-medium text-purple-700 dark:text-purple-300">Spend $100 Save 10%</span>
                                <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>
                            <button
                                wire:click="addTieredRule"
                                class="flex w-full items-center justify-between rounded-lg border border-purple-200 bg-purple-50 px-4 py-3 text-sm transition-colors hover:bg-purple-100 dark:border-purple-900/50 dark:bg-purple-900/20 dark:hover:bg-purple-900/30"
                            >
                                <span class="font-medium text-purple-700 dark:text-purple-300">Volume Discount (Tiered)</span>
                                <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>
                        </div>
                        @if ($this->rules->isNotEmpty())
                            <button
                                wire:click="clearRules"
                                class="mt-4 w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                            >
                                Clear All Rules
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
