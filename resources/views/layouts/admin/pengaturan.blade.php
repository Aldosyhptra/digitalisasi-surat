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

<body class="bg-gray-50">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('components.sidebar_admin')

        {{-- Main Content --}}
        <main class="flex-1 min-h-screen overflow-x-hidden overflow-y-auto bg-gray-50">
            {{-- Navbar --}}
            @include('components.navbar_admin')

            {{-- Page Content --}}
            <div class="p-6">
                @yield('content')
                @include('components.Admin/Pengaturan/pengaturan')
            </div>
        </main>

    </div>

</body>
</html>
