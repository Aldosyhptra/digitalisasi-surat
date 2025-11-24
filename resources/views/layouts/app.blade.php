<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Digitalisasi Surat' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Content --}}
    <main class="container mx-auto w-full px-4 py-6 flex-grow">
        @yield('content')
    </main>

    {{-- Footer tetap di bawah --}}
    <footer class="bg-white shadow-inner py-4 text-center">
        <small class="text-gray-500">© {{ date('Y') }} Digitalisasi Surat. All rights reserved.</small>
    </footer>

    @vite('resources/js/app.js')
</body>

</html>
