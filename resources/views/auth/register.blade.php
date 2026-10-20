@extends('layouts.auth')
@section('title', 'Daftar Akun')
@section('content')
<form method="POST" action="{{ route('register') }}" class="space-y-4 auth-rise">
    @csrf
    <div>
        <label for="name" class="block text-sm font-semibold mb-1.5">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="auth-input @error('name') border-red-600 @enderror">
        @error('name')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="phone" class="block text-sm font-semibold mb-1.5">Nomor HP</label>
        <input id="phone" type="tel" inputmode="numeric" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="08xxxxxxxxxx" class="auth-input @error('phone') border-red-600 @enderror">
        @error('phone')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-semibold mb-1.5">Password</label>
        <x-password-toggle><input id="password" type="password" name="password" required autocomplete="new-password" class="auth-input pl-4 pr-16"></x-password-toggle>
        <p class="text-xs text-warm-gray mt-1">Minimal 8 karakter.</p>
        @error('password')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-semibold mb-1.5">Konfirmasi Password</label>
        <x-password-toggle><input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="auth-input pl-4 pr-16"></x-password-toggle>
    </div>
    <button type="submit" class="auth-btn">Daftar</button>
    <p class="text-center text-sm text-warm-gray">Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk</a></p>
</form>
@endsection
