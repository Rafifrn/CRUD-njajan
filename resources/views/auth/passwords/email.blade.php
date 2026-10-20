@extends('layouts.auth')
@section('title', 'Lupa Password')
@section('content')
@if (session('status'))<div class="mb-4 p-3 rounded-lg bg-sage-mist text-deep-forest text-sm" role="status">{{ session('status') }}</div>@endif
<form method="POST" action="{{ route('password.email') }}" class="space-y-4">
    @csrf
    <div>
        <label for="email" class="block text-sm font-bold mb-1.5">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="field w-full @error('email') border-red-600 @enderror">
        @error('email')<p class="text-red-700 text-sm mt-1" role="alert">{{ $message }}</p>@enderror
    </div>
    <button type="submit" class="btn btn-primary w-full">Kirim Link Reset</button>
    <a href="{{ route('login') }}" class="block text-center text-sm font-bold text-mauve-bark underline">Kembali ke login</a>
</form>
@endsection
