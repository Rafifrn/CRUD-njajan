<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
    <title>@yield('title') — {{ config('app.name') }}</title>
</head>
<body class="min-h-screen grid place-items-center p-4 relative overflow-x-hidden">
    <div aria-hidden="true">
        <div class="auth-blob w-80 h-80 bg-lime-glow/40 -top-20 -left-20"></div>
        <div class="auth-blob w-96 h-96 bg-mauve-bark/20 -bottom-32 -right-24" style="animation-delay:-5s"></div>
        <div class="auth-blob w-64 h-64 bg-amber-300/40 top-1/3 right-1/4" style="animation-delay:-9s"></div>
    </div>
    <main class="relative w-full max-w-md py-8">
        <p class="text-center text-6xl sm:text-7xl font-extrabold tracking-tighter text-coffee-bean mb-1" aria-label="Njajan">
            @foreach (str_split('Njajan') as $i => $c)<span class="auth-letter" style="animation-delay:{{ $i * 70 }}ms" aria-hidden="true">{{ $c }}</span>@endforeach
        </p>
        <p class="text-center text-warm-gray mb-8 auth-card">Jajanan UMKM Nusantara</p>
        <div class="auth-card rounded-3xl bg-white/70 backdrop-blur-xl border border-white p-6 sm:p-8 shadow-xl shadow-amber-900/10">
            <h1 class="text-2xl mb-6">@yield('title')</h1>
            @yield('content')
        </div>
    </main>
</body>
</html>
