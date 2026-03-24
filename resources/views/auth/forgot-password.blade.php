<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 space-y-2">
        <p><strong>Lupa kata sandi?</strong> Masukkan alamat email yang terdaftar, lalu kami kirim link reset ke email Anda.</p>
        <p>Setelah email diterima, buka link tersebut untuk masuk ke halaman reset dan buat kata sandi baru.</p>
        <p class="text-xs text-gray-500">Jika email belum masuk, cek folder Spam/Junk. Jika muncul pesan "Silakan tunggu sebelum mencoba lagi", tunggu sekitar 1 menit lalu kirim ulang.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Kirim Link Reset Password
            </x-primary-button>
        </div>

        <div class="mt-4 text-sm text-gray-600 text-right">
            <a href="{{ route('login') }}" class="underline hover:text-gray-900">Kembali ke halaman login</a>
        </div>
    </form>
</x-guest-layout>
