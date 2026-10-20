@extends('layouts.user')
@section('title', 'Beranda — Njajan')
@section('content')
<section class="relative isolate overflow-hidden rounded-[2rem] bg-gradient-to-br from-coffee-bean to-mauve-bark text-amber-50 px-6 py-14 md:px-14 md:py-24 mb-8">
    <div aria-hidden="true">
        <div class="auth-blob w-72 h-72 bg-lime-glow/40 -top-16 -right-10"></div>
        <div class="auth-blob w-80 h-80 bg-amber-200/20 -bottom-24 left-1/4" style="animation-delay:-6s"></div>
    </div>
    <div class="auth-rise">
        <p class="inline-block rounded-full bg-white/10 backdrop-blur px-4 py-1.5 text-sm font-semibold mb-5">Halo, {{ Str::before(Auth::user()->name, ' ') }}</p>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tighter leading-[1.02] max-w-3xl">Jajan apa <span class="text-lime-glow">hari ini?</span></h1>
        <p class="mt-5 text-amber-100/90 max-w-xl text-lg">Pilih tenant UMKM favoritmu, atau langsung jelajahi semua menu dalam satu keranjang.</p>
        <a href="{{ route('order') }}" class="group mt-8 inline-flex items-center gap-3 rounded-full bg-lime-glow text-coffee-bean font-bold pl-7 pr-2 py-2 transition duration-300 hover:bg-amber-300 hover:shadow-xl hover:shadow-black/30 active:scale-95">
            Lihat Semua Menu
            <span class="grid place-items-center w-10 h-10 rounded-full bg-coffee-bean text-amber-50 transition duration-300 group-hover:translate-x-1"><x-icon name="arrow" class="w-5 h-5" /></span>
        </a>
    </div>
</section>

@if ($tenants->count())
<div class="marquee overflow-hidden mb-12 [mask-image:linear-gradient(90deg,transparent,#000_8%,#000_92%,transparent)]" aria-hidden="true">
    <div class="marquee-track">
        @foreach ([1, 2] as $_)
            @foreach ($tenants as $tenant)
                <span class="rounded-full border border-warm-sand bg-white px-5 py-2 text-sm font-semibold whitespace-nowrap">{{ $tenant->name }}</span>
            @endforeach
        @endforeach
    </div>
</div>
@endif

<h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-6">Tenant UMKM</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    @forelse ($tenants as $tenant)
        <a href="{{ route('order') }}?tenant={{ $tenant->slug }}" class="tenant-card group reveal">
            <div class="aspect-square bg-coffee-bean flex items-center justify-center overflow-hidden">
                @if ($tenant->logo)
                    <img src="{{ asset('storage/'.$tenant->logo) }}" alt="" loading="lazy" class="h-full w-full object-cover">
                @else
                    <x-icon name="store" class="w-12 h-12 text-lime-glow" />
                @endif
            </div>
            <div class="p-4 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h3 class="font-bold text-lg truncate">{{ $tenant->name }}</h3>
                    <p class="text-sm text-warm-gray line-clamp-2">{{ $tenant->description }}</p>
                    <p class="text-xs font-semibold text-mauve-bark mt-3">{{ $tenant->makanans_count }} makanan · {{ $tenant->minumen_count }} minuman</p>
                </div>
                <span class="tenant-arrow shrink-0"><x-icon name="arrow" class="w-4 h-4" /></span>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-16 text-warm-gray">
            <x-icon name="store" class="w-12 h-12 mx-auto mb-3" /> Belum ada tenant yang tersedia.
        </div>
    @endforelse
</div>
@endsection
