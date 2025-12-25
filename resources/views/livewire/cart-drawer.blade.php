<div>
    <!-- Backdrop -->
    <div
        x-data="{ open: @entangle('open') }"
        x-show="open"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="$wire.closeDrawer()"
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
        x-cloak
    ></div>

    <!-- Drawer -->
    <div
        x-data="{ open: @entangle('open') }"
        x-show="open"
        x-transition:enter="transition-transform duration-300 ease-out"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition-transform duration-300 ease-in"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed right-0 top-0 z-50 flex h-full w-full max-w-md flex-col bg-white shadow-2xl dark:bg-gray-900"
        x-cloak
    >
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Shopping Cart</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $this->count }} {{ Str::plural('item', $this->count) }}</p>
                </div>
            </div>
            <button
                wire:click="closeDrawer"
                class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Items -->
        <div class="flex-1 overflow-y-auto px-6 py-4">
            @if ($this->items->isEmpty())
                <div class="flex h-full flex-col items-center justify-center text-center">
                    <div class="mb-4 rounded-full bg-gray-100 p-6 dark:bg-gray-800">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-1 text-lg font-medium text-gray-900 dark:text-gray-100">Your cart is empty</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Add some products to get started!</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($this->items as $item)
                        <div class="flex gap-4 rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50" wire:key="drawer-item-{{ $item->id }}">
                            <!-- Product Image Placeholder -->
                            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600">
                                <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>

                            <!-- Details -->
                            <div class="flex flex-1 flex-col">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $item->name }}</h4>
                                        @if (!empty($item->attributes->toArray()))
                                            <div class="mt-1 flex flex-wrap gap-1">
                                                @foreach ($item->attributes->toArray() as $key => $value)
                                                    <span class="rounded bg-gray-200 px-1.5 py-0.5 text-xs text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                        {{ ucfirst($key) }}: {{ $value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <button
                                        wire:click="removeItem('{{ $item->id }}')"
                                        class="ml-2 rounded p-1 text-gray-400 transition-colors hover:bg-gray-200 hover:text-red-500 dark:hover:bg-gray-700"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <button
                                            wire:click="updateQuantity('{{ $item->id }}', {{ $item->quantity - 1 }})"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-200 text-gray-600 transition-colors hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="w-8 text-center font-medium">{{ $item->quantity }}</span>
                                        <button
                                            wire:click="updateQuantity('{{ $item->id }}', {{ $item->quantity + 1 }})"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-200 text-gray-600 transition-colors hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $item->subtotal()->format() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if (!$this->items->isEmpty())
            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
                <div class="mb-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                        <span class="font-medium">{{ $this->subtotal->format() }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span class="text-indigo-600 dark:text-indigo-400">{{ $this->total->format() }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button
                        wire:click="clearCart"
                        wire:confirm="Are you sure you want to clear the cart?"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Clear Cart
                    </button>
                    <a
                        href="/cart"
                        wire:navigate
                        class="flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-lg shadow-indigo-500/25 transition-all hover:bg-indigo-700"
                    >
                        View Full Cart
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
