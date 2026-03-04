@extends('layouts.guest')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 text-center">Login Admin</h1>
    <p class="text-sm text-gray-500 text-center mt-1 mb-6">Akses dashboard pengelolaan antrian.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between pt-2">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 rounded-xl px-6">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <p class="text-sm text-center text-gray-600 pt-2">
            Login sebagai pasien?
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Klik di sini</a>
        </p>
    </form>
@endsection
