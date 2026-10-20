@extends('layouts.auth')
@section('title', 'Verifikasi Email')
@section('content')
@if (session('resent'))<div class="mb-4 p-3 rounded-lg bg-sage-mist text-deep-forest text-sm" role="status">Link verifikasi baru telah dikirim.</div>@endif
<p class="text-warm-gray text-sm mb-4">Cek email Anda untuk link verifikasi. Belum menerima?</p>
<form method="POST" action="{{ route('verification.resend') }}" class="space-y-3">@csrf
    <button type="submit" class="btn btn-primary w-full">Kirim Ulang</button>
</form>
<form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">@csrf
    <button type="submit" class="text-sm font-bold text-mauve-bark underline">Keluar</button>
</form>
@endsection
