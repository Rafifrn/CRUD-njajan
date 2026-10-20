@php
$map = ['pending' => ['Menunggu', 'bg-sage-mist text-deep-forest'], 'diproses' => ['Diproses', 'bg-amber-200 text-coffee-bean'],
        'selesai' => ['Selesai', 'bg-lime-glow text-coffee-bean'], 'dibatalkan' => ['Dibatalkan', 'bg-red-100 text-red-800']];
[$label, $cls] = $map[$status] ?? [ucfirst($status), 'bg-sage-mist text-deep-forest'];
@endphp
<span class="badge {{ $cls }}">{{ $label }}</span>
