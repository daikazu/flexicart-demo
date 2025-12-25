<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Documentation</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Learn how to use FlexiCart in your Laravel application.</p>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Sidebar / Table of Contents -->
            <aside class="lg:col-span-3">
                <nav class="sticky top-24 space-y-1">
                    <div class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Table of Contents
                    </div>
                    @foreach ($sections as $key => $section)
                        <button
                            wire:click="setSection('{{ $key }}')"
                            class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium transition-colors {{ $currentSection === $key ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
                        >
                            {{ $section['title'] }}
                        </button>
                    @endforeach
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="mt-8 lg:col-span-9 lg:mt-0">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
                    <article class="prose prose-indigo max-w-none dark:prose-invert prose-headings:scroll-mt-24 prose-h1:text-2xl prose-h2:text-xl prose-h2:border-b prose-h2:border-gray-200 prose-h2:pb-2 dark:prose-h2:border-gray-700 prose-pre:p-0 prose-pre:bg-transparent">
                        {!! $renderedContent !!}
                    </article>
                </div>

                <!-- Navigation -->
                <div class="mt-6 flex items-center justify-between">
                    @php
                        $keys = array_keys($sections);
                        $currentIndex = array_search($currentSection, $keys);
                        $prevSection = $currentIndex > 0 ? $keys[$currentIndex - 1] : null;
                        $nextSection = $currentIndex < count($keys) - 1 ? $keys[$currentIndex + 1] : null;
                    @endphp

                    @if ($prevSection)
                        <button
                            wire:click="setSection('{{ $prevSection }}')"
                            class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            {{ $sections[$prevSection]['title'] }}
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if ($nextSection)
                        <button
                            wire:click="setSection('{{ $nextSection }}')"
                            class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            {{ $sections[$nextSection]['title'] }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @else
                        <div></div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</div>
