    <!-- Navigation -->
    <nav class="border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        📝 Blog
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('posts.index') }}"
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                        Home
                    </a>
                    <a href="{{ route('posts.create') }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                        Nowy Post
                    </a>
                    <button id="theme-toggle" type="button"
                        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">
                        <span id="theme-toggle-icon">🌙</span>
                        <span id="theme-toggle-label">Ciemny</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>
