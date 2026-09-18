<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Verifikasi Email</h2>

            @if (session('resent'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <p class="text-gray-600 text-sm mb-6 text-center">
                Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi.
                Jika Anda tidak menerima email,
            </p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <div class="text-center mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
