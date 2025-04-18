@extends('layouts.app')

@section('content')
    {{-- Full‑screen container that centers content --}}
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        {{-- Card with rounded corners, white background and shadow --}}
        <div class="w-full max-w-sm space-y-2 bg-white rounded-xl shadow-md p-6">
            {{-- Heading and subtitle --}}
            <div class="text-start">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Sign up') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Create your account by filling the information below') }}
                </p>
            </div>

            {{-- Registration form --}}
            <form class="space-y-2" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name field --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Name') }}
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        autocomplete="name"
                        autofocus
                        value="{{ old('name') }}"
                        placeholder="{{ __('Full name') }}"
                        class="block w-full rounded-md border @error('name') border-red-500 @else border-gray-300 @enderror px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                    @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email field --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Email address') }}
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autocomplete="email"
                        value="{{ old('email') }}"
                        placeholder="{{ __('Email address') }}"
                        class="block w-full rounded-md border @error('email') border-red-500 @else border-gray-300 @enderror px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password field --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Password') }}
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="{{ __('Password') }}"
                        class="block w-full rounded-md border @error('password') border-red-500 @else border-gray-300 @enderror px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm password field --}}
                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Confirm password') }}
                    </label>
                    <input
                        id="password-confirm"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="{{ __('Repeat your password') }}"
                        class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                </div>

                {{-- Submit button --}}
                <div>
                    <button
                        type="submit"
                        class="group relative flex w-full justify-center rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        {{ __('Sign up') }}
                    </button>
                </div>
            </form>

            {{-- Sign‑in link --}}
            <p class="text-center text-sm text-gray-600">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    {{ __('Sign in') }}
                </a>
            </p>
        </div>
    </div>
@endsection
