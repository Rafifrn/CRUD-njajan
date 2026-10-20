@extends('layouts.auth')
@section('title', 'Masuk')
@section('content')
<form method="POST" action="{{ route('login') }}" class="space-y-4 auth-rise">
    @csrf
    <div>
        <label for="phone" class="block text-sm font-semibold mb-1.5">Nomor HP</label>
        <input id="phone" type="tel" inputmode="numeric" name="phone" value="{{ old('phone') }}" required autofocus autocomplete="tel" placeholder="08xxxxxxxxxx"
               class="auth-input @error('phone') border-red-600 @enderror">
        @error('phone')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-semibold mb-1.5">Password</label>
        <x-password-toggle><input id="password" type="password" name="password" required autocomplete="current-password" class="auth-input pl-4 pr-16"></x-password-toggle>
        @error('password')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="rounded accent-mauve-bark"> Ingat saya</label>
    <button type="submit" class="auth-btn">Masuk</button>
    <p class="text-center text-sm text-warm-gray">Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar</a></p>
</form>
@endsection
