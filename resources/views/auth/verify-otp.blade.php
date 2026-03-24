@extends('layouts.guest')

@section('content')
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 text-center">Verifikasi OTP</h1>
    <p class="text-sm text-gray-500 text-center mt-1 mb-6">
        Kami sudah kirim kode OTP ke <span class="font-semibold text-gray-700">{{ $email }}</span>
    </p>

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify.submit') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="otp" :value="__('Kode OTP (6 digit)')" />
            <x-text-input id="otp" class="block mt-1 w-full rounded-xl text-center tracking-[0.4em]" type="text" name="otp" :value="old('otp')" required autofocus inputmode="numeric" maxlength="6" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center rounded-xl px-6">
            {{ __('Verifikasi & Login') }}
        </x-primary-button>
    </form>

    <form method="POST" action="{{ route('otp.verify.resend') }}" class="mt-4">
        @csrf
        <button type="submit" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            Kirim Ulang OTP
        </button>
    </form>

    @if(!empty($expiresAt))
        <p class="text-xs text-gray-500 text-center mt-3">
            OTP berlaku sampai {{ $expiresAt->format('H:i') }}
        </p>
    @endif
@endsection
