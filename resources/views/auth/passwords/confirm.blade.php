@extends('layouts.auth')
@section('title', 'Konfirmasi Password')
@section('content')
<p class="text-warm-gray text-sm mb-4">Konfirmasi password Anda sebelum melanjutkan.</p>
<form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
    @csrf
    <div>
        <label for="password" class="block text-sm font-bold mb-1.5">Password</label>
        <x-password-toggle><input id="password" type="password" name="password" required autofocus autocomplete="current-password" class="field w-full pl-4 pr-16"></x-password-toggle>
        @error('password')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <button type="submit" class="btn btn-primary w-full">Konfirmasi</button>
    @if (Route::has('password.request'))<a href="{{ route('password.request') }}" class="block text-center text-sm font-bold text-mauve-bark underline">Lupa password?</a>@endif
</form>
@endsection
