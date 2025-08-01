@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="w-full mt-12 mx-auto bg-white rounded-lg shadow-md p-6">
        <header>
            <h2 class="text-lg font-semibold text-gray-900 ">
                {{ __('Update Password') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input id="update_password_password" name="password" type="password"
                    class="mt-1 block w-full placeholder:font-light" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">8-character minimum; texs sensitive</p>
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full placeholder:font-light" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">masukkan ulang password</p>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
@endsection