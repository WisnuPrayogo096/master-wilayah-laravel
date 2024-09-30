<div id="loginContainer" class="bg-white bg-opacity-20 rounded-3xl p-8 shadow-xl w-full max-w-md transition-all duration-300 hover:scale-105 hover:shadow-2xl focus:scale-105 focus:shadow-2xl active:scale-100 active:shadow-lg">
    <div class="text-center mb-8">
        <div class="inline-block animate-rotate">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-gray-700">
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                <circle cx="12" cy="10" r="3" />
            </svg>
        </div>
        <h2 class="mt-4 text-3xl font-bold text-gray-700">Master Wilayah</h2>
        <p class="text-gray-500 mt-3">Login to Dashboard</p>
    </div>
    <form wire:submit="login">
        <div class="mb-6">
            <label for="password" class="block text-gray-500 text-sm font-semibold mb-2">Password</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input type="password" id="password" wire:model.blur="password" name="password"
                    class="w-full bg-white bg-opacity-10 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-300 hover:scale-102 focus:scale-102"
                    placeholder="••••••••" autofocus>
            </div>
            @error('password')
                <span class="block text-sm text-red-500 mt-2">{{$message}}</span>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-blue-400 to-indigo-500 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:from-blue-500 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
            Login
        </button>
    </form>

    <div class="mt-6 text-center">
        <a class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-300">&#169; Developed by IT RSU UMM</a>
    </div>
</div>
