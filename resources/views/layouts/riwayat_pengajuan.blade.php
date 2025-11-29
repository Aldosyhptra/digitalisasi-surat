<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Digitalisasi Surat' }}</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="flex h-screen bg-gray-50">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">

        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Content Section --}}
        <main class="flex-1 p-4 md:p-6 overflow-auto">
            @yield('content')
            @include('components.Pengguna.RiwayatPengajuan.riwayat')

        </main>

        {{-- Footer --}}
        <footer class="bg-white shadow-inner py-4 text-center">
            <small class="text-gray-500">
                © {{ date('Y') }} Digitalisasi Surat. All rights reserved.
            </small>
        </footer>

    </div>

</body>
</html>
