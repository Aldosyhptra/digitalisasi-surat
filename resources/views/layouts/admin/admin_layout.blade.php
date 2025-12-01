<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Digitalisasi Surat' }}</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-gray-50">

    <div class="flex">

        @include('components.sidebar_admin')

        <main class="flex-1">
            @include('components.navbar_admin')

            <div class="p-6 space-y-6">
                {{-- HALAMAN UTAMA --}}
                @yield('content')

                {{-- STATISTIK ADMIN --}}
                @include('components.admin.dashboard.statistik')

                @include('components.admin.dashboard.datapemohon')

            </div>

        </main>

    </div>

</body>
</html>
