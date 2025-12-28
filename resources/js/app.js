import './bootstrap';

document.addEventListener('alpine:init', () => {
    Alpine.data('DarkModeToggle', () => {
        return {
            mode: 'dark',
            init() {
                this.setInitialMode();
            },
            setInitialMode() {
                const storedTheme = window.localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
                    this.enableDarkMode();
                } else {
                    this.disableDarkMode();
                }
            },
            toggleDarkMode() {
                if (this.mode === 'dark') {
                    this.disableDarkMode();
                } else {
                    this.enableDarkMode();
                }
            },
            enableDarkMode() {
                document.documentElement.classList.add('dark');
                window.localStorage.setItem('theme', 'dark');
                this.mode = 'dark';
            },
            disableDarkMode() {
                document.documentElement.classList.remove('dark');
                window.localStorage.setItem('theme', 'light');
                this.mode = 'light';
            },
        };
    });
});
