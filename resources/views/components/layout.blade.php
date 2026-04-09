<!DOCTYPE html>
<html lang="pl" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Lista Postów</title>

    <script>
        (() => {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldUseDark = savedTheme === 'dark' || (!savedTheme && prefersDark);

            if (shouldUseDark) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css'])
</head>

<body class="h-full bg-gray-50 text-gray-900 transition-colors dark:bg-gray-900 dark:text-gray-100">
    @include('partials.navigation')

    <div id="duck-widget" class="fixed left-3 top-20 z-50">
        <button id="duck-button" type="button"
            class="group relative flex h-14 w-14 items-center justify-center rounded-full border-2 border-amber-300 bg-amber-100 text-3xl shadow-lg transition hover:-translate-y-0.5 hover:bg-amber-200"
            aria-label="Duck jokes">
            🦆
            <span
                class="pointer-events-none absolute -right-16 -top-2 rounded-full bg-gray-900 px-2 py-1 text-[10px] font-semibold uppercase tracking-wide text-white opacity-90">
                click me
            </span>
        </button>

        <div id="duck-joke-bubble"
            class="mt-3 hidden max-w-xs rounded-xl border border-amber-200 bg-white px-4 py-3 text-sm text-gray-800 shadow-xl dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            <p id="duck-joke-text">Hello dev.</p>
        </div>
    </div>

    {{ $slot }}

    @include('partials.footer')

    @vite(['resources/js/app.js'])
</body>

</html>
