<div class="py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-16 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-100 px-4 py-1.5 text-sm font-medium text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                daikazu/flexicart
            </span>
            <h1 class="mt-6 text-4xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-5xl">
                A Flexible Shopping Cart for Laravel
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-500 dark:text-gray-400">
                Everything you need to build powerful e-commerce experiences. Conditions, rules engine, precise pricing, and seamless Laravel integration.
            </p>
        </div>

        <!-- Main Features -->
        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Flexible Storage -->
            <div class="rounded-2xl border border-gray-200 bg-white p-8 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/50">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-gray-100">Flexible Storage</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Choose between session storage (default) or database storage. Perfect for guest carts and persistent user carts.
                </p>
                <pre class="mt-4 overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100"><code>// config/flexicart.php
'storage' => env('CART_STORAGE', 'session'),</code></pre>
            </div>

            <!-- Conditions System -->
            <div class="rounded-2xl border border-gray-200 bg-white p-8 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/50">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-gray-100">Powerful Conditions</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Apply percentage or fixed-amount conditions to items or the entire cart. Stack multiple conditions with custom ordering.
                </p>
                <pre class="mt-4 overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100"><code>$discount = new PercentageCondition(
    name: '10% Off',
    value: -10,
    target: ConditionTarget::SUBTOTAL
);
Cart::addCondition($discount);</code></pre>
            </div>

            <!-- Rules Engine -->
            <div class="rounded-2xl border border-gray-200 bg-white p-8 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/50">
                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-gray-100">Smart Rules Engine</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Context-aware promotional rules: Buy X Get Y, threshold discounts, tiered volume discounts, and more.
                </p>
                <pre class="mt-4 overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100"><code>$rule = new BuyXGetYRule(
    name: 'Buy 2 Get 1 Free',
    buyQuantity: 2,
    getQuantity: 1,
    getDiscount: 100.0
);
Cart::addRule($rule);</code></pre>
            </div>
        </div>

        <!-- More Features Grid -->
        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Precise Pricing -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/50">
                    <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Brick/Money Integration</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Precise currency handling with no floating-point errors.
                </p>
            </div>

            <!-- Custom Attributes -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 dark:bg-pink-900/50">
                    <svg class="h-5 w-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Custom Attributes</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Store color, size, or any custom data with cart items.
                </p>
            </div>

            <!-- Taxable Items -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100 dark:bg-teal-900/50">
                    <svg class="h-5 w-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Taxable Support</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Mark items as taxable or non-taxable for proper tax calculations.
                </p>
            </div>

            <!-- Event System -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 dark:bg-orange-900/50">
                    <svg class="h-5 w-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Event System</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Hook into cart actions for analytics and inventory management.
                </p>
            </div>

            <!-- Cart Merging -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/50">
                    <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Cart Merging</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Merge guest carts with user carts using flexible strategies.
                </p>
            </div>

            <!-- Item Conditions -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-100 dark:bg-cyan-900/50">
                    <svg class="h-5 w-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Item Conditions</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Apply discounts or fees to individual cart items.
                </p>
            </div>

            <!-- Easy API -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-lime-100 dark:bg-lime-900/50">
                    <svg class="h-5 w-5 text-lime-600 dark:text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Simple API</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Clean, expressive API with Laravel Facade support.
                </p>
            </div>

            <!-- Laravel Integration -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/50">
                    <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h4 class="mb-1 font-semibold text-gray-900 dark:text-gray-100">Laravel Native</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Built specifically for Laravel 11+ with PHP 8.3+ support.
                </p>
            </div>
        </div>

        <!-- Code Examples -->
        <div class="mt-16">
            <h2 class="mb-8 text-center text-2xl font-bold text-gray-900 dark:text-gray-100">Quick Start</h2>
            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Basic Usage -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">Basic Cart Operations</h3>
                    <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100"><code>use Daikazu\Flexicart\Facades\Cart;

// Add an item
Cart::addItem([
    'id' => 1,
    'name' => 'Product Name',
    'price' => 29.99,
    'quantity' => 2,
    'attributes' => [
        'color' => 'blue',
        'size' => 'large'
    ]
]);

// Get cart totals
$subtotal = Cart::subtotal();
$total = Cart::total();
$count = Cart::count();</code></pre>
                </div>

                <!-- Conditions -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-800/50">
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">Conditions & Rules</h3>
                    <pre class="overflow-x-auto rounded-lg bg-gray-900 p-4 text-xs text-gray-100"><code>use Daikazu\Flexicart\Conditions\Types\*;
use Daikazu\Flexicart\Conditions\Rules\*;

// Add a percentage discount
Cart::addCondition(new PercentageCondition(
    name: 'Holiday Sale',
    value: -15,
    target: ConditionTarget::SUBTOTAL
));

// Add a threshold rule
Cart::addRule(new ThresholdRule(
    name: 'Spend $100 Save 10%',
    minSubtotal: 100.00,
    discount: -10.0,
    discountType: ConditionType::PERCENTAGE
));</code></pre>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-16 text-center">
            <div class="rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 p-12">
                <h2 class="text-2xl font-bold text-white">Ready to get started?</h2>
                <p class="mx-auto mt-4 max-w-xl text-indigo-100">
                    Install FlexiCart in your Laravel project and build powerful e-commerce experiences in minutes.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <pre class="rounded-lg bg-white/10 px-6 py-3 font-mono text-sm text-white backdrop-blur-sm"><code>composer require daikazu/flexicart</code></pre>
                    <a href="https://github.com/daikazu/flexicart" target="_blank" class="inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 font-medium text-indigo-600 shadow-lg transition-all hover:bg-indigo-50">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.604-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10z" />
                        </svg>
                        View on GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
