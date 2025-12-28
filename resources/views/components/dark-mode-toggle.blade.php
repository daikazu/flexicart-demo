<div
    x-data="DarkModeToggle"
    x-id="['dark-mode-toggle']"
    {{ $attributes->merge(['class' => 'grid']) }}
    x-on:keydown.ctrl.clear.window="toggleDarkMode()"
>
    <button type="button" x-on:click="toggleDarkMode()" title="Toggle Dark Mode">
        <x-heroicon-o-sun x-show="mode === 'light'" class="text-accent size-6 shrink-0" aria-hidden="true" />
        <x-heroicon-o-moon x-show="mode === 'dark'" class="size-6 shrink-0 text-neutral-50" aria-hidden="true" />
        <span class="sr-only" x-text="mode === 'light' ? 'Turn on dark mode' : 'Turn on light mode'"></span>
    </button>
</div>
