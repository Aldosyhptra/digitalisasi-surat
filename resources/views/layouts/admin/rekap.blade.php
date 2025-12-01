<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Portal' }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{-- Include libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('components.sidebar_admin')

        <main class="flex-1 flex flex-col">

            {{-- Navbar --}}
            @include('components.navbar_admin')

            {{-- Main Content --}}
            <div class="p-6 flex flex-col gap-6">

                {{-- Konten yang di-yield --}}
                @yield('content')

                {{-- Komponen Rekap Statistik --}}
                <div class="mb-6">
                    @include('components.Admin/Rekap/rekap_statistik')
                </div>

                {{-- Komponen Rekap Filter & Download --}}
                <div class="mb-6">
                    @include('components.Admin/Rekap/rekap')
                </div>

            </div>
        </main>
    </div>

</body>
</html>
