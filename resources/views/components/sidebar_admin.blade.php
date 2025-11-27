<aside
    class="bg-white border-r border-gray-200 flex flex-col h-screen
            w-[70px] md:w-64 transition-all duration-200">

    {{-- Logo --}}
    <div class="flex items-center p-4">
        <div
            class="bg-blue-600 rounded-lg p-2 flex items-center justify-center 
                    w-12 h-12 mx-auto md:mx-0">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo">
        </div>

        <div class="hidden md:flex flex-col ml-3 mt-1 space-y-1">
            <span class="font-bold text-gray-900 leading-none">Admin Portal</span>
            <span class="text-sm text-gray-400 leading-none">Desa Digital</span>
        </div>
    </div>

    <hr class="border-gray-200 my-2 hidden md:block">

    {{-- Menu --}}
    @php
        $menus = [
            ['href' => route('admin.dashboard'), 'icon' => 'fa-home', 'text' => 'Dashboard'],
            ['href' => route('admin.permohonan'), 'icon' => 'fa-file-alt', 'text' => 'Data Permohonan'],
            ['href' => route('admin.surat'), 'icon' => 'fa-copy', 'text' => 'Manajemen Surat'],
            ['href' => route('admin.rekap'), 'icon' => 'fa-chart-bar', 'text' => 'Rekap & Laporan'],
            ['href' => route('admin.pengaturan'), 'icon' => 'fa-user-cog', 'text' => 'Pengaturan Akun'],
        ];
    @endphp

    <nav class="flex-1 px-2 py-4 flex flex-col gap-6">
        @foreach ($menus as $menu)
            <a href="{{ $menu['href'] }}"
                class="flex items-center gap-4 px-3 py-2 rounded-md 
                      text-[#4B5563] hover:bg-blue-50 hover:text-blue-700 
                      transition-colors duration-200">

                <i class="fa {{ $menu['icon'] }} text-lg w-5 mx-auto md:mx-0"></i>

                <span class="hidden md:inline-flex font-medium">
                    {{ $menu['text'] }}
                </span>
            </a>
        @endforeach
    </nav>

    {{-- Logout --}}
    <div class="px-2 py-4 mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar?')"
                class="flex w-full items-center gap-4 px-3 py-2 rounded-md hover:bg-gray-100 
                           text-red-600 transition-colors duration-200">

                <i class="fa fa-sign-out-alt text-lg w-5 mx-auto md:mx-0"></i>

                <span class="hidden md:inline-flex font-medium">Logout</span>
            </button>
        </form>
    </div>

</aside>
