<div>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 py-16">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjwvZz48L2c+PC9zdmc+')] opacity-20"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-white backdrop-blur-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Powered by FlexiCart for Laravel
                </span>
                <h1 class="mt-6 text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Flexible Shopping Cart
                    <span class="block text-indigo-200">Made Simple</span>
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-indigo-100">
                    No product database required. Add items from any source — APIs, arrays, or your own models. Features a powerful conditions system and rules engine.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <a href="#products" class="rounded-lg bg-white px-6 py-3 text-sm font-semibold text-indigo-600 shadow-lg transition-all hover:bg-indigo-50 hover:shadow-xl">
                        Browse Products
                    </a>
                    <a href="/features" wire:navigate class="rounded-lg border border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20">
                        View Features
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Products</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $this->products->count() }} products available</p>
                </div>
                <div class="flex items-center gap-3">
                    <label for="category" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by:</label>
                    <select
                        wire:model.live="selectedCategory"
                        id="category"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    >
                        <option value="">All Categories</option>
                        @foreach ($this->categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($this->products as $product)
                    <div
                        class="group relative flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all hover:shadow-lg dark:border-gray-800 dark:bg-gray-800/50"
                        wire:key="product-{{ $product->id }}"
                    >
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="h-20 w-20 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <!-- Category Badge -->
                            <div class="absolute left-3 top-3">
                                <span class="rounded-full bg-white/90 px-2.5 py-1 text-xs font-medium text-gray-700 shadow-sm backdrop-blur-sm dark:bg-gray-900/90 dark:text-gray-300">
                                    {{ $product->category }}
                                </span>
                            </div>
                            <!-- Taxable Badge -->
                            @if (!$product->taxable)
                                <div class="absolute right-3 top-3">
                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/50 dark:text-green-300">
                                        Tax Free
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                            <p class="mt-1 line-clamp-2 text-sm text-gray-500 dark:text-gray-400">{{ $product->description }}</p>

                            <!-- Variants -->
                            @if ($product->colors || $product->sizes)
                                <div class="mt-4 space-y-3">
                                    @if ($product->colors)
                                        <div>
                                            <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Color</label>
                                            <select
                                                wire:model="selectedColors.{{ $product->id }}"
                                                class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800"
                                            >
                                                <option value="">Select Color</option>
                                                @foreach ($product->colors as $color)
                                                    <option value="{{ $color }}">{{ $color }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if ($product->sizes)
                                        <div>
                                            <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Size</label>
                                            <select
                                                wire:model="selectedSizes.{{ $product->id }}"
                                                class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-800"
                                            >
                                                <option value="">Select Size</option>
                                                @foreach ($product->sizes as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Price & Add to Cart -->
                            <div class="mt-auto flex items-center justify-between pt-4">
                                <div class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                                <button
                                    wire:click="addToCart({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-wait"
                                    wire:target="addToCart({{ $product->id }})"
                                    class="flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-indigo-500/25 transition-all hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-500/30 disabled:opacity-50"
                                >
                                    <svg wire:loading.remove wire:target="addToCart({{ $product->id }})" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <svg wire:loading wire:target="addToCart({{ $product->id }})" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Feature Highlights -->
    <section class="border-t border-gray-200 bg-gray-50 py-12 dark:border-gray-800 dark:bg-gray-900/50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Try These Coupon Codes</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Add items to cart and apply these codes on the cart page</p>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-white p-4 text-center dark:border-gray-700 dark:bg-gray-800">
                    <div class="font-mono text-lg font-bold text-indigo-600 dark:text-indigo-400">SAVE10</div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">10% off your order</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-4 text-center dark:border-gray-700 dark:bg-gray-800">
                    <div class="font-mono text-lg font-bold text-indigo-600 dark:text-indigo-400">FLAT20</div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">$20 off your order</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-4 text-center dark:border-gray-700 dark:bg-gray-800">
                    <div class="font-mono text-lg font-bold text-indigo-600 dark:text-indigo-400">SUMMER25</div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">25% off your order</p>
                </div>
            </div>
        </div>
    </section>
</div>
