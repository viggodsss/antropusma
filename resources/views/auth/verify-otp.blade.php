@extends('layouts.guest')

@section('content')
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-100 text-center">Verifikasi OTP</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1 mb-6">Masukkan kode OTP 6 digit yang dikirim ke email Anda.</p>

    @if (session('status'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify.store') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl" type="email" name="email" :value="old('email', $email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="otp" :value="__('Kode OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full rounded-xl tracking-[0.35em] text-center" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" name="otp" :value="old('otp')" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center rounded-xl px-6">
            {{ __('Verifikasi OTP') }}
        </x-primary-button>
    </form>

    <form method="POST" action="{{ route('otp.verify.resend') }}" class="mt-3">
        @csrf
        <input type="hidden" name="email" value="{{ old('email', $email) }}">
        <button type="submit" class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
            Kirim Ulang OTP
        </button>
    </form>

    <a href="{{ route('login') }}" class="inline-block mt-5 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 underline">
        Kembali ke Login
    </a>
@endsection
