<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Veyangoda.lk</title>

        <!-- Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Alpine.js -->
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                primary: '#00A651',
                                secondary: '#F3F4F6',
                                dark: '#1F2937',
                                'dark-green': '#064E3B',
                                'hero-green': '#10B981',
                                'light-green': '#34D399',
                                'accent-yellow': '#FACC15',
                            },
                            boxShadow: {
                                'card': '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)',
                                'card-hover': '0 4px 6px rgba(0,0,0,0.1), 0 2px 4px rgba(0,0,0,0.06)',
                            }
                        }
                    }
                }
            </script>
        @endif
    </head>
    <body class="font-sans antialiased bg-secondary text-dark flex flex-col min-h-screen">
        
        <!-- Navbar Component -->
        <x-navbar />

        @isset($header)
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Main Content -->
        <main class="flex-1 w-full">
            {{ $slot }}
        </main>

        <!-- Footer Component -->
        <x-footer />
    </body>
</html>
