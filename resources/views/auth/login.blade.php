<x-guest-layout>

    {{-- Session status (mis. setelah reset password) --}}
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 border-l-4 border-green-500 px-4 py-3 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="admin@perpus.test"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                Password
            </label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                          focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                Ingat saya
            </label>
        </div>

        {{-- Tombol --}}
        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                       py-2.5 rounded-lg shadow transition">
            Masuk
        </button>

        {{-- Info akun asesor --}}
        <div class="text-center text-xs text-gray-500 border-t pt-4">
            <p class="font-medium text-gray-600 mb-1">Akun untuk pengujian:</p>
            <p>Email: <span class="font-mono text-indigo-600">admin@perpus.test</span></p>
            <p>Password: <span class="font-mono text-indigo-600">password</span></p>
        </div>
    </form>

</x-guest-layout>