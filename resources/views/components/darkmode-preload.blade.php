{{-- set darkmode before body render to prevent flashing with view-transitions --}}
{{-- format-ignore-start --}}
<script>
const storedTheme=window.localStorage.getItem("theme"),prefersDark=window.matchMedia("(prefers-color-scheme: dark)").matches;"dark"===storedTheme||!storedTheme&&prefersDark?(document.documentElement.classList.add("dark"),window.localStorage.setItem("theme","dark")):(document.documentElement.classList.remove("dark"),window.localStorage.setItem("theme","light"));
</script>
{{-- format-ignore-end --}}
