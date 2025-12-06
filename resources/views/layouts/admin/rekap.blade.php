<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Portal' }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex">

    <div class="flex w-full min-h-screen">

        {{-- SIDEBAR --}}
        @include('components.sidebar_admin')

        {{-- MAIN AREA --}}
        <main class="flex-1 flex flex-col min-h-screen overflow-x-hidden">

            {{-- NAVBAR --}}
            <header class="sticky top-0 z-30 bg-white shadow">
                @include('components.navbar_admin')
            </header>

            {{-- CONTENT --}}
            <section class="p-4 md:p-6 flex flex-col gap-6">

                {{-- Halaman lain --}}
                @yield('content')

                {{-- Rekap Statistik --}}
                <div class="w-full">
                    @include('components.Admin.Rekap.rekap_statistik')
                </div>

                {{-- Rekap Filter & Download --}}
                <div class="w-full">
                    @include('components.Admin.Rekap.rekap')
                </div>

            </section>

        </main>

    </div>

</body>
</html>
