<x-app-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-secondary">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-card p-8">
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-4">
                    V
                </div>
                <h2 class="text-2xl font-bold text-dark">Welcome back</h2>
                <p class="text-sm text-gray-500 mt-2">Log in to your Veyangoda.lk account</p>
            </div>

            <!-- Session Status / Errors -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-100 text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-700 text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-dark mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-dark outline-none transition-colors @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-dark mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-dark outline-none transition-colors @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:underline">Forgot password?</a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full py-3 px-4 bg-primary hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Log in
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">Don't have an account? 
                    <a href="{{ route('register') }}" class="font-bold text-primary hover:underline">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
