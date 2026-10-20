@extends('layouts.user')
@section('title', 'Pesan — Njajan')

@section('content')
@php
    $items = collect($makanans)->map(fn ($m) => ['type' => 'makanan', 'cat' => strtolower($m->category ?? 'makanan'), 'm' => $m])
        ->concat(collect($minumans)->map(fn ($m) => ['type' => 'minuman', 'cat' => 'minuman', 'm' => $m]));
@endphp

<h1 class="page-title mb-6">Pesan</h1>

<div class="mb-6 flex flex-col md:flex-row md:items-center gap-3 md:gap-6 border-b border-warm-sand">
    <div class="flex gap-6 overflow-x-auto -mb-px [scrollbar-width:none]" role="group" aria-label="Kategori">
        @foreach (['semua' => 'Semua', 'makanan' => 'Makanan', 'jajanan' => 'Jajanan', 'minuman' => 'Minuman'] as $key => $label)
            <button type="button" data-cat="{{ $key }}" class="cat-btn shrink-0 py-3 text-sm font-semibold text-warm-gray border-b-2 border-transparent transition-colors hover:text-coffee-bean aria-pressed:text-coffee-bean aria-pressed:border-coffee-bean">{{ $label }}</button>
        @endforeach
    </div>
    <div class="md:ml-auto pb-3 md:pb-0">
        <label for="filter-tenant" class="sr-only">Tenant</label>
        <select id="filter-tenant" class="field w-full md:w-auto md:min-w-48 rounded-full py-2 pl-4 text-sm font-semibold">
            <option value="semua">Semua tenant</option>
            @foreach ($tenants as $tenant)
                <option value="{{ $tenant->slug }}" @selected(request('tenant') === $tenant->slug)>{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid lg:grid-cols-[1fr_22rem] gap-6 items-start pb-24 lg:pb-0">
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5" id="items">
        @foreach ($items as $row)
            @php $p = $row['m']; $img = $p->image ? (str_starts_with($p->image, 'http') ? $p->image : asset('storage/'.$p->image)) : null; @endphp
            <article class="item-card card overflow-hidden flex flex-col cursor-pointer hover:shadow-lg transition-shadow duration-200"
                     data-category="{{ $row['cat'] }}" data-tenant="{{ $p->tenant->slug ?? '' }}"
                     data-name="{{ $p->name }}" data-desc="{{ $p->description }}" data-tenant-name="{{ $p->tenant->name ?? 'Tenant' }}" data-price="{{ (int) $p->price }}" data-img="{{ $img }}">
                <div class="h-44 bg-sage-mist overflow-hidden">
                    @if ($img)
                        <img src="{{ $img }}" alt="{{ $p->name }}" loading="lazy" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-warm-gray"><x-icon name="image" class="w-10 h-10" /></div>
                    @endif
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h2 class="font-sans font-bold text-lg leading-snug" style="font-family:var(--font-sans);letter-spacing:0"><button type="button" class="text-left">{{ $p->name }}</button></h2>
                    <p class="text-xs font-semibold text-mauve-bark mb-1">{{ $p->tenant->name ?? 'Tenant' }}</p>
                    <p class="text-sm text-warm-gray line-clamp-2 mb-3">{{ $p->description }}</p>
                    <div class="mt-auto flex items-center justify-between gap-2">
                        <span class="font-bold text-lg">Rp{{ number_format($p->price, 0, ',', '.') }}</span>
                        <button type="button" class="add-btn btn btn-dark btn-sm"
                                data-type="{{ $row['type'] }}" data-id="{{ $p->id }}" data-name="{{ $p->name }}"
                                data-price="{{ (int) $p->price }}" data-tenant="{{ $p->tenant->name ?? '' }}"
                                aria-label="Tambah {{ $p->name }} ke keranjang">Tambah</button>
                        <div class="qty hidden items-center gap-2" data-key="{{ $row['type'] }}-{{ $p->id }}">
                            <button type="button" class="dec w-9 h-9 rounded-full bg-sage-mist font-bold" aria-label="Kurangi">−</button>
                            <span class="qty-n font-bold min-w-6 text-center" aria-live="polite">0</span>
                            <button type="button" class="inc w-9 h-9 rounded-full bg-coffee-bean text-amber-50 font-bold" aria-label="Tambah">+</button>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
        <p id="empty" class="hidden col-span-full text-center py-16 text-warm-gray">Tidak ada menu untuk filter ini.</p>
    </div>

    <aside id="cart" class="card overflow-hidden max-lg:hidden max-lg:fixed max-lg:bottom-0 max-lg:inset-x-0 max-lg:z-40 max-lg:rounded-b-none max-lg:border-b-0 max-lg:shadow-[0_-4px_12px_rgba(0,0,0,.15)] max-lg:pb-[env(safe-area-inset-bottom)] lg:sticky lg:top-24" aria-label="Keranjang">
        <button type="button" id="cart-toggle" aria-expanded="false" aria-controls="cart-body" class="table-head w-full text-left px-5 py-4 flex items-center gap-2 lg:cursor-default">
            <x-icon name="cart" class="w-5 h-5 text-lime-glow" />
            <h2 class="font-sans font-bold text-lg" style="font-family:var(--font-sans);letter-spacing:0">Keranjang</h2>
            <span id="cart-count" class="badge bg-lime-glow text-coffee-bean">0</span>
            <span id="cart-sum" class="ml-auto font-bold lg:hidden">Rp0</span>
            <x-icon name="chevron" class="w-4 h-4 lg:hidden" />
        </button>
        <div id="cart-body" class="hidden lg:block p-5 max-lg:max-h-[60vh] overflow-y-auto">
            <p id="cart-empty" class="text-center text-warm-gray py-6 text-sm">Keranjang masih kosong.</p>
            <div id="cart-items" class="space-y-3"></div>
            <div id="cart-foot" class="hidden">
                <p id="cart-note" class="text-xs text-mauve-bark mt-3"></p>
                <div class="flex justify-between items-center border-t border-warm-sand mt-4 pt-4">
                    <span class="font-bold">Total</span><span id="cart-total" class="text-2xl font-bold">Rp0</span>
                </div>
                <button id="checkout-btn" type="button" class="btn btn-primary w-full mt-4">Checkout</button>
                <p id="cart-error" class="text-sm text-red-700 mt-2 hidden" role="alert"></p>
            </div>
        </div>
    </aside>
</div>

<dialog id="menu-modal" aria-labelledby="mm-name" class="m-auto w-[calc(100%-2rem)] max-w-md rounded-[20px] bg-white p-0 text-forest-shadow shadow-2xl backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="relative">
        <button type="button" id="mm-close" aria-label="Tutup" class="absolute top-3 right-3 z-10 grid place-items-center w-10 h-10 rounded-full bg-white/90 shadow hover:bg-white transition"><x-icon name="x" class="w-5 h-5" /></button>
        <div id="mm-imgbox" class="aspect-square bg-sage-mist"><img id="mm-img" src="" alt="" class="w-full h-full object-contain"></div>
        <div class="p-6">
            <p id="mm-tenant" class="text-xs font-semibold text-mauve-bark mb-1"></p>
            <h2 id="mm-name" class="font-sans font-bold text-2xl leading-snug" style="font-family:var(--font-sans);letter-spacing:0"></h2>
            <p id="mm-desc" class="text-warm-gray mt-2 whitespace-pre-line"></p>
            <div class="mt-5 flex items-center justify-between gap-3">
                <p id="mm-price" class="font-bold text-2xl"></p>
                <button type="button" id="mm-add" class="btn btn-dark">Tambah ke Keranjang</button>
                <div id="mm-qty" class="hidden items-center gap-3">
                    <button type="button" id="mm-dec" class="w-11 h-11 rounded-full bg-sage-mist font-bold text-lg" aria-label="Kurangi">−</button>
                    <span id="mm-n" class="font-bold min-w-6 text-center text-lg" aria-live="polite">0</span>
                    <button type="button" id="mm-inc" class="w-11 h-11 rounded-full bg-coffee-bean text-amber-50 font-bold text-lg" aria-label="Tambah">+</button>
                </div>
            </div>
        </div>
    </div>
</dialog>
@endsection

@section('scripts')
<script>
const cart = {};
let activeCat = 'semua', activeTenant = @json(request('tenant') ?? 'semua');
const rp = (n) => 'Rp' + n.toLocaleString('id-ID');
const $ = (s, r = document) => r.querySelector(s);
const $$ = (s, r = document) => [...r.querySelectorAll(s)];
const esc = (s) => s.replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

function applyFilters() {
    let shown = 0;
    $$('.item-card').forEach((c) => {
        const ok = (activeCat === 'semua' || c.dataset.category === activeCat) && (activeTenant === 'semua' || c.dataset.tenant === activeTenant);
        c.classList.toggle('hidden', !ok); shown += ok;
    });
    $('#empty').classList.toggle('hidden', shown > 0);
    $$('.cat-btn').forEach((b) => {
        const on = b.dataset.cat === activeCat;
        b.setAttribute('aria-pressed', on);
    });
}
$$('.cat-btn').forEach((b) => b.addEventListener('click', () => { activeCat = b.dataset.cat; applyFilters(); }));
$('#filter-tenant').addEventListener('change', (e) => { activeTenant = e.target.value; applyFilters(); });

const modal = $('#menu-modal');
let modalCard = null;
function syncModal() {
    if (!modalCard) return;
    const a = $('.add-btn', modalCard).dataset, it = cart[`${a.type}-${a.id}`];
    $('#mm-add').classList.toggle('hidden', !!it);
    $('#mm-qty').classList.toggle('hidden', !it); $('#mm-qty').classList.toggle('flex', !!it);
    if (it) $('#mm-n').textContent = it.qty;
}
const modalKey = () => { const a = $('.add-btn', modalCard).dataset; return `${a.type}-${a.id}`; };
$('#mm-add').addEventListener('click', () => $('.add-btn', modalCard).click());
$('#mm-inc').addEventListener('click', () => change(modalKey(), 1));
$('#mm-dec').addEventListener('click', () => change(modalKey(), -1));
modal.addEventListener('close', () => { modalCard = null; });
$$('.item-card').forEach((c) => c.addEventListener('click', (e) => {
    if (e.target.closest('.add-btn, .qty')) return;
    const d = c.dataset;
    $('#mm-name').textContent = d.name;
    $('#mm-tenant').textContent = d.tenantName;
    $('#mm-desc').textContent = d.desc || 'Belum ada deskripsi.';
    $('#mm-price').textContent = rp(+d.price);
    $('#mm-img').src = d.img; $('#mm-img').alt = d.name;
    $('#mm-imgbox').classList.toggle('hidden', !d.img);
    modalCard = c; syncModal();
    modal.showModal();
}));
$('#mm-close').addEventListener('click', () => modal.close());
modal.addEventListener('click', (e) => { if (e.target === modal) modal.close(); }); // click on backdrop

function change(key, delta, info) {
    if (!cart[key]) { if (delta < 0) return; cart[key] = { ...info, qty: 0 }; }
    cart[key].qty += delta;
    if (cart[key].qty <= 0) delete cart[key];
    render();
}
$$('.add-btn').forEach((b) => b.addEventListener('click', () => {
    const d = b.dataset;
    change(`${d.type}-${d.id}`, 1, { type: d.type, id: +d.id, name: d.name, price: +d.price, tenant: d.tenant });
}));
$$('.qty').forEach((q) => {
    q.querySelector('.inc').addEventListener('click', () => change(q.dataset.key, 1));
    q.querySelector('.dec').addEventListener('click', () => change(q.dataset.key, -1));
});

function render() {
    let total = 0, count = 0; const byTenant = {};
    const list = $('#cart-items'); list.innerHTML = '';
    Object.entries(cart).forEach(([key, it]) => {
        total += it.price * it.qty; count += it.qty; byTenant[it.tenant] = 1;
        list.insertAdjacentHTML('beforeend', `
          <div class="flex items-start justify-between gap-3 text-sm">
            <div><p class="font-bold">${esc(it.name)}</p><p class="text-xs text-warm-gray">${esc(it.tenant)} · ${rp(it.price)} × ${it.qty}</p></div>
            <div class="flex items-center gap-1.5 shrink-0">
              <button type="button" data-k="${key}" data-d="-1" class="w-8 h-8 rounded-full bg-sage-mist font-bold" aria-label="Kurangi ${esc(it.name)}">−</button>
              <button type="button" data-k="${key}" data-d="1" class="w-8 h-8 rounded-full bg-coffee-bean text-amber-50 font-bold" aria-label="Tambah ${esc(it.name)}">+</button>
            </div>
          </div>`);
    });
    $$('#cart-items button').forEach((b) => b.addEventListener('click', () => change(b.dataset.k, +b.dataset.d)));
    $$('.qty').forEach((q) => {
        const it = cart[q.dataset.key], add = $(`.add-btn[data-type="${q.dataset.key.split('-')[0]}"][data-id="${q.dataset.key.split('-')[1]}"]`);
        q.classList.toggle('hidden', !it); q.classList.toggle('flex', !!it); add.classList.toggle('hidden', !!it);
        if (it) $('.qty-n', q).textContent = it.qty;
    });
    const n = Object.keys(byTenant).length;
    $('#cart-count').textContent = count;
    $('#cart-total').textContent = $('#cart-sum').textContent = rp(total);
    $('#cart').classList.toggle('max-lg:hidden', count === 0);
    $('#cart-note').textContent = '';
    $('#cart-empty').classList.toggle('hidden', count > 0);
    $('#cart-foot').classList.toggle('hidden', count === 0);
    syncModal();
}

$('#cart-toggle').addEventListener('click', (e) => {
    const open = $('#cart-body').classList.toggle('hidden') === false;
    e.currentTarget.setAttribute('aria-expanded', open);
});

$('#checkout-btn').addEventListener('click', async () => {
    const btn = $('#checkout-btn'), err = $('#cart-error');
    err.classList.add('hidden'); btn.disabled = true; btn.textContent = 'Memproses…';
    try {
        const res = await fetch(@json(route('checkout')), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json',
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ items: Object.values(cart).map((i) => ({ product_type: i.type, id: i.id, qty: i.qty })) }),
        });
        const r = await res.json();
        if (!r.success) throw new Error(r.message || 'Terjadi kesalahan');
        window.location.href = r.redirect_url || @json(route('pesanan'));
    } catch (e) {
        err.textContent = 'Gagal: ' + e.message; err.classList.remove('hidden');
        btn.disabled = false; btn.textContent = 'Checkout';
    }
});

applyFilters(); render();
</script>
@endsection
