<x-guest-layout>

    {{-- Notifikasi sukses (mis. setelah logout) --}}
    @if (session('success'))
        <div class="mb-4 flex items-start gap-2 bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm">
            <span class="text-lg">✅</span>
            <span class="text-sm">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Notifikasi error umum (mis. session expired) --}}
    @if (session('error'))
        <div class="mb-4 flex items-start gap-2 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-sm">
            <span class="text-lg">❌</span>
            <span class="text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Notifikasi login gagal (email/password salah) --}}
    @if ($errors->any())
        <div class="mb-4 flex items-start gap-2 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-sm">
            <span class="text-lg">⚠️</span>
            <div class="text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
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
                          focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-sm text-red-600 mt-1">📧 {{ $message }}</p>
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
                          focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-sm text-red-600 mt-1">🔒 {{ $message }}</p>
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