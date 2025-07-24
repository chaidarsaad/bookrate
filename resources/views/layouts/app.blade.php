<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <title>@yield('title')</title>

     <script>
        const originalWarn = console.warn;

        console.warn = function(message, ...args) {
            if (
                typeof message === "string" &&
                message.includes(
                    "cdn.tailwindcss.com should not be used in production"
                )
            ) {
                return;
            }
            originalWarn.apply(console, [message, ...args]);
        };
    </script>

    <script src="https://cdn.tailwindcss.com"></script>

    @stack('addon-style')
</head>

<body>
    <nav class="fixed top-0 left-0 w-full bg-white shadow z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 text-xl font-semibold text-blue-600">
                    BookRate
                </div>

                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-blue-600 transition
                    {{ Route::is('home') ? 'text-blue-600 font-semibold' : '' }}">
                        Book List
                    </a>

                    <a href="{{ route('top.books') }}"
                        class="text-gray-700 hover:text-blue-600 transition
                    {{ Route::is('top.books') ? 'text-blue-600 font-semibold' : '' }}">
                        Top Books
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="hamburger-button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobile-menu"
                class="md:hidden hidden bg-white shadow-lg absolute left-0 right-0 top-16 px-6 py-4 space-y-4">
                <a href="{{ route('home') }}"
                    class="block text-gray-700 hover:text-blue-600 transition
                {{ Route::is('home') ? 'text-blue-600 font-semibold' : '' }}">
                    Book List
                </a>

                <a href="{{ route('top.books') }}"
                    class="block text-gray-700 hover:text-blue-600 transition
                {{ Route::is('top.books') ? 'text-blue-600 font-semibold' : '' }}">
                    Top Books
                </a>
            </div>
        </div>
    </nav>

    @yield('content')

    @stack('addon-script')

    <script>
        document.getElementById('hamburger-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
