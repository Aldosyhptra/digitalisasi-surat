<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Digitalisasi Surat' }}</title>

    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-gray-50 min-h-screen">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('components.sidebar_admin')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-h-screen overflow-x-hidden">

            {{-- NAVBAR --}}
            @include('components.navbar_admin')

            {{-- PAGE WRAPPER --}}
            <div class="p-4 sm:p-6 space-y-6">

                {{-- CONTENT --}}
                @yield('content')

            </div>
        </main>

    </div>

</body>

</html>
