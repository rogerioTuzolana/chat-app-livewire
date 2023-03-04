@extends('name')
@section('name')
    <div>
        <a name="logo">
            App
        </a>

        <span class="errors" class="mb-4">...</span>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <label for="email" >{{ __('Email') }}</label>
                <input id="email" class="block mt-1 w-full" type="email" name="email" value="old('email', $request->email)" required />
            </div>

            <div class="mt-4">
                <label for="password" value="{{ __('Password') }}"> </label>
                <input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div class="mt-4">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button>
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
   
@endsection
