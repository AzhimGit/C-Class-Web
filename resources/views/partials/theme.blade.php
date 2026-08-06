{{-- Tailwind CDN + config dark mode class-based --}}
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class', 
    };
</script>

{{-- Jalankan SEBELUM render agar tidak kedip (flash) saat reload --}}
<script>
    (function () {
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();
</script>

<style>
    html { color-scheme: light; }
    html.dark { color-scheme: dark; }
</style>

{{-- Fungsi toggle tema --}}
<script>
    function toggleTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }
</script>