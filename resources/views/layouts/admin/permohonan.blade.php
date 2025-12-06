<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Portal' }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex">

    <!-- Wrapper -->
    <div class="flex w-full min-h-screen">

        {{-- Sidebar --}}
        @include('components.sidebar_admin')

        {{-- MAIN --}}
        <main class="flex-1 min-h-screen overflow-x-hidden">

            {{-- Navbar --}}
            <header class="sticky top-0 z-30 bg-white shadow-sm">
                @include('components.navbar_admin')
            </header>

            {{-- Page Content --}}
            <section class="p-4 md:p-6">
                @yield('content')
                @include('components.Admin.Permohonan.permohonan')
            </section>

        </main>

    </div>

</body>
</html>
