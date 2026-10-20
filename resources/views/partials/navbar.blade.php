{{-- expects $links = [[label, routeName, activePattern]], optional $badge. Floating glass navbar (integratedbio.com style) --}}
@php $link = 'inline-flex items-center h-10 px-4 rounded-lg text-[13px] uppercase tracking-wide font-medium transition-colors duration-300'; @endphp
<header class="sticky top-0 z-50 pt-4 px-4">
    <nav class="container mx-auto" aria-label="Utama">
        <div class="flex items-center justify-between h-16 lg:h-14 rounded-2xl lg:rounded-none px-3 lg:px-0 bg-white/80 backdrop-blur-lg border border-coffee-bean/5 lg:bg-transparent lg:backdrop-blur-none lg:border-0">
            <a href="{{ $brandUrl ?? route('home') }}" class="flex items-center gap-2 text-xl font-bold tracking-wide text-coffee-bean">
                <x-icon name="cup" class="w-6 h-6 text-mauve-bark" /> NJAJAN
                @isset($badge)<span class="ml-1 badge bg-coffee-bean text-amber-50">{{ $badge }}</span>@endisset
            </a>
            <div class="hidden lg:flex items-center gap-1 rounded-xl bg-white/80 backdrop-blur-lg border border-coffee-bean/5 p-1 pl-3">
                @foreach ($links as [$label, $route, $pattern])
                    <a href="{{ route($route) }}" @if(request()->routeIs($pattern)) aria-current="page" @endif
                       class="{{ $link }} {{ request()->routeIs($pattern) ? 'bg-sage-mist' : 'hover:bg-sage-mist' }}">{{ $label }}</a>
                @endforeach
                <div class="relative ml-2">
                    <button id="userDropdownToggle" aria-expanded="false" aria-haspopup="true" class="{{ $link }} gap-2 bg-coffee-bean text-amber-50 hover:bg-mauve-bark">
                        {{ Auth::user()->name }} <x-icon name="chevron" class="w-4 h-4" />
                    </button>
                    <div id="userDropdownMenu" class="hidden absolute right-0 mt-3 w-44 card overflow-hidden shadow-lg">
                        <form action="{{ route('logout') }}" method="POST">@csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-[13px] uppercase tracking-wide font-medium hover:bg-sage-mist">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
            <button id="mobile-menu-button" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu" class="lg:hidden grid place-items-center w-12 h-12 rounded-xl bg-coffee-bean text-amber-50">
                <x-icon name="menu" class="w-6 h-6" />
            </button>
        </div>
        <div id="mobile-menu" class="hidden lg:hidden mt-2 p-2 rounded-2xl bg-white/90 backdrop-blur-lg border border-coffee-bean/5 shadow-lg space-y-1">
            @foreach ($links as [$label, $route, $pattern])
                <a href="{{ route($route) }}" class="{{ $link }} w-full h-12 {{ request()->routeIs($pattern) ? 'bg-sage-mist' : 'hover:bg-sage-mist' }}">{{ $label }}</a>
            @endforeach
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="{{ $link }} w-full h-12 bg-coffee-bean text-amber-50">Keluar</button>
            </form>
        </div>
    </nav>
</header>
