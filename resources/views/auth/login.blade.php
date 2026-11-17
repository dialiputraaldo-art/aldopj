<x-guest-layout>

    {{-- Popup liquid glass untuk notifikasi --}}
    <div id="glass-popup-container"
         class="fixed top-6 right-4 sm:right-6 z-[60] flex flex-col gap-3 w-[calc(100%-2rem)] sm:w-96 pointer-events-none">

        @if (session('success'))
            <div class="glass-popup popup-enter pointer-events-auto rounded-2xl px-5 py-4 flex items-start gap-3">
                <div class="shrink-0 w-9 h-9 rounded-full bg-green-500 text-white flex items-center justify-center font-bold">✓</div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-green-900">Berhasil</p>
                    <p class="text-sm text-gray-800 leading-snug">{{ session('success') }}</p>
                </div>
                <button onclick="closePopup(this)" class="shrink-0 text-gray-500 hover:text-gray-800 text-lg leading-none">×</button>
            </div>
        @endif

        @if (session('error'))
            <div class="glass-popup-error popup-enter pointer-events-auto rounded-2xl px-5 py-4 flex items-start gap-3">
                <div class="shrink-0 w-9 h-9 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">!</div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-red-900">Gagal</p>
                    <p class="text-sm text-gray-800 leading-snug">{{ session('error') }}</p>
                </div>
                <button onclick="closePopup(this)" class="shrink-0 text-gray-500 hover:text-gray-800 text-lg leading-none">×</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="glass-popup-error popup-enter pointer-events-auto rounded-2xl px-5 py-4 flex items-start gap-3">
                <div class="shrink-0 w-9 h-9 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">!</div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-red-900">Gagal masuk</p>
                    <ul class="text-sm text-gray-800 list-disc list-inside leading-snug">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="closePopup(this)" class="shrink-0 text-gray-500 hover:text-gray-800 text-lg leading-none">×</button>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="admin@perpus.test"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <p class="text-sm text-red-600 mt-1">📧 {{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <p class="text-sm text-red-600 mt-1">🔒 {{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow transition">
            Masuk
        </button>

        <div class="text-center text-xs text-gray-500 border-t pt-4">
            <p class="font-medium text-gray-600 mb-1">Akun untuk pengujian:</p>
            <p>Email: <span class="font-mono text-indigo-600">admin@perpus.test</span></p>
            <p>Password: <span class="font-mono text-indigo-600">password</span></p>
        </div>
    </form>

    {{-- CSS + script popup --}}
    <style>
        .glass-popup {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.25);
        }
        .glass-popup-error {
            background: rgba(254, 226, 226, 0.55);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(252, 165, 165, 0.6);
            box-shadow: 0 8px 32px rgba(185, 28, 28, 0.25);
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px) scale(0.96); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to   { opacity: 0; transform: translateX(40px) scale(0.96); }
        }
        .popup-enter { animation: slideInRight 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        .popup-leave { animation: fadeOut 0.35s ease-in forwards; }
    </style>
    <script>
        function closePopup(btn) {
            const popup = btn.closest('div[class*="popup-enter"]') || btn.parentElement;
            popup.classList.remove('popup-enter');
            popup.classList.add('popup-leave');
            setTimeout(() => popup.remove(), 350);
        }
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.popup-enter').forEach((el, i) => {
                setTimeout(() => {
                    if (el && el.parentElement) {
                        el.classList.remove('popup-enter');
                        el.classList.add('popup-leave');
                        setTimeout(() => el.remove(), 350);
                    }
                }, 4000 + i * 200);
            });
        });
    </script>

</x-guest-layout>