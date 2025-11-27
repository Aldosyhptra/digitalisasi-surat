<aside
    class="bg-white border-r border-gray-200 flex flex-col h-screen 
            w-[70px] md:w-64 transition-all duration-200">

    {{-- Logo --}}
    <div class="flex items-center p-4">

        {{-- Box Logo --}}
        <div
            class="bg-blue-600 rounded-lg p-2 flex items-center justify-center 
                    w-12 h-12 mx-auto md:mx-0">
            <img src="/images/Logo.png" alt="Logo">
        </div>

        {{-- Teks hanya tampil di md ke atas --}}
        <div class="hidden md:flex flex-col ml-3 mt-1 space-y-1">
            <span class="font-bold text-gray-900 leading-none">Admin Portal</span>
            <span class="text-sm text-gray-400 leading-none">Desa Digital</span>
        </div>
    </div>

    <hr class="border-gray-200 my-2 hidden md:block">

    {{-- Menu --}}
    <nav class="flex-1 px-2 py-4 flex flex-col gap-6">
        @php
            $menus = [
                ['href' => '#', 'icon' => 'fa-home', 'text' => 'Dashboard'],
                ['href' => '#', 'icon' => 'fa-file-alt', 'text' => 'Ajukan Surat'],
                ['href' => '#', 'icon' => 'fa-clock', 'text' => 'Riwayat Pengajuan'],
                ['href' => '#', 'icon' => 'fa-question-circle', 'text' => 'Bantuan / FAQ'],
                ['href' => '#', 'icon' => 'fa-user', 'text' => 'Profil Saya'],
            ];
        @endphp

        @foreach ($menus as $menu)
            <a href="{{ $menu['href'] }}"
                class="flex items-center gap-4 px-3 py-2 rounded-md 
                      text-[#4B5563] hover:bg-blue-50 hover:text-blue-700 
                      transition-colors duration-200">

                {{-- Ikon --}}
                <i class="fa {{ $menu['icon'] }} w-5 text-lg mx-auto md:mx-0 text-[#4B5563]"></i>

                {{-- Teks --}}
                <span class="font-medium hidden md:inline-flex text-[#4B5563]">
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
