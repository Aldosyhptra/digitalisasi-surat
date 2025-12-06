<header class="bg-white shadow px-4 md:px-6 py-4 
                flex flex-col md:flex-row md:justify-between md:items-center gap-4">

    {{-- Judul --}}
    <div>
        <h1 class="text-xl font-bold text-gray-900">
            {{ $title ?? 'Dashboard Penduduk' }}
        </h1>
        <p class="text-gray-500 text-sm">
            Selamat datang kembali, kelola semua aktivitas desa
        </p>
    </div>

    {{-- Right area --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end 
                gap-4 md:gap-6 w-full md:w-auto">

        {{-- Tombol Ajukan --}}
        <a href="{{ route('pengajuan.surat') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded 
                   flex items-center gap-2 hover:bg-blue-700 transition 
                   w-full sm:w-auto justify-center">
            <i class="fas fa-plus"></i>
            <span>Ajukan Surat Baru</span>
        </a>

        {{-- Notifikasi --}}
        <button class="relative text-gray-700 hover:text-gray-900 
                       w-full sm:w-auto flex justify-center items-center">
            <div class="relative inline-block">
                <i class="fas fa-bell text-lg"></i>

                {{-- Badge menempel sempurna pada icon --}}
                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 
                             bg-red-500 rounded-full border border-white"></span>
            </div>
        </button>

        {{-- Profil --}}
        <a href="{{ route('profil.saya') }}"
           class="flex items-center gap-3 
                  w-full sm:w-auto justify-center sm:justify-start">

            <img src="/images/pp.png" class="w-10 h-10 rounded-full object-cover">

            {{-- Info user muncul di layar > sm --}}
            <div class="hidden sm:flex flex-col leading-tight">
                <span class="font-medium text-gray-900">
                    {{ $user->name ?? 'Penduduk' }}
                </span>
                <span class="text-sm text-gray-500">
                    {{ $user->nik ?? '221293982843' }}
                </span>
            </div>

        </a>

    </div>
</header>
