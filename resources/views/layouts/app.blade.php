<!DOCTYPE html>
<html lang="en" class="min-h-screen bg-gradient-to-br from-gray-100 to-indigo-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Master Wilayah')</title>
    <link rel="icon" href="{{ asset("rsu-umm.png") }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @stack('styles')
    @livewireStyles
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 hover:scale-110 transition-all duration-300 ease-in-out transform" src="{{ asset("rsu-umm.png") }}" type="image/png" alt="RSU UMM">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4 text-white px-3 py-2 text-base font-semibold">
                                <h1>Hai, Admin</h1>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a wire:navigate href="{{ route('provinsi') }}" class="text-white hover:bg-blue-600 hover:bg-opacity-75 rounded-md px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">Home</a>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-white hover:bg-blue-600 hover:bg-opacity-75 rounded-md px-3 py-2 text-sm font-medium transition duration-150 ease-in-out">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-white rounded-md px-3 py-2 text-sm font-medium" id="currentTime">
                        <!-- Time will be displayed here -->
                    </div>
                </div>
            </div>
        </nav>

        <main class="fade-in">
           {{$slot}}
        </main>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')
    @livewireScripts
</body>
</html>
