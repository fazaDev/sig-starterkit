<script>
    (function () {
        const stored = localStorage.getItem('theme');
        const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;

        document.documentElement.classList.toggle('dark', isDark);
        document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
    })();
</script>
