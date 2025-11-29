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

<body class="flex h-screen bg-gray-50 overflow-hidden">

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Content Section --}}
        <main class="flex-1 p-4 md:p-6 overflow-auto">

            {{-- Statistik --}}
            @include('components.Pengguna.Dashboard.statistik')

            {{-- WRAPPER UTAMA → Dua Kolom (Responsive) --}}
            <div class="flex flex-col lg:flex-row gap-6 mt-6">

                {{-- Left Column → Pengajuan --}}
                <div class="flex-1">
                    @include('components.Pengguna.pengajuan')
                </div>

                {{-- Right Column → Tracking + Support --}}
                <div class="flex-1 flex flex-col gap-6">

                    {{-- Card Tracking --}}
                    <div class="flex justify-start">
                        <div class="w-full sm:w-[340px]">
                            @include('components.Pengguna.tracking')
                        </div>
                    </div>

                    {{-- Card Support --}}
                    <div class="flex justify-start">
                        <div class="w-full sm:w-[328px]">
                            @include('components.Pengguna.support')
                        </div>
                    </div>

                </div>
            </div>

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
