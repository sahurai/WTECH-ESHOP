@extends('layouts.app')

@section('content')
    {{-- Full‑screen container that centers content --}}
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        {{-- Card with rounded corners, white background and shadow --}}
        <div class="w-full max-w-sm space-y-2 bg-white rounded-xl shadow-md p-6">
            {{-- Heading and subtitle --}}
            <div class="text-start">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Sign in') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Enter your email below to login to your account') }}
                </p>
            </div>

            {{-- Login form --}}
            <form class="space-y-2" method="POST" action="{{ route('login') }}">
                @csrf

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
                        autocomplete="current-password"
                        placeholder="{{ __('Password') }}"
                        class="block w-full rounded-md border @error('password') border-red-500 @else border-gray-300 @enderror px-3 py-2 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me checkbox --}}
                <div class="flex items-center">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        {{ __('Remember me') }}
                    </label>
                </div>

                {{-- Submit button --}}
                <div>
                    <button
                        type="submit"
                        class="group relative flex w-full justify-center rounded-md bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        {{ __('Sign in') }}
                    </button>
                </div>
            </form>

            {{-- Registration link --}}
            <p class="text-center text-sm text-gray-600">
                {{ __("Don't have account?") }}
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    {{ __('Sign up') }}
                </a>
            </p>
        </div>
    </div>
@endsection
