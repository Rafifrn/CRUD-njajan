@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
        <label for="email" class="block text-sm font-bold mb-1.5">Email</label>
        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus class="field w-full @error('email') border-red-600 @enderror">
        @error('email')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-bold mb-1.5">Password Baru</label>
        <x-password-toggle><input id="password" type="password" name="password" required autocomplete="new-password" class="field w-full pl-4 pr-16"></x-password-toggle>
        @error('password')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-bold mb-1.5">Konfirmasi Password</label>
        <x-password-toggle><input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="field w-full pl-4 pr-16"></x-password-toggle>
    </div>
    <button type="submit" class="btn btn-primary w-full">Reset Password</button>
</form>
@endsection
