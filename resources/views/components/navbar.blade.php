<nav class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 flex items-center justify-between h-16">
        {{-- Brand --}}
        <a href="/" class="text-xl font-semibold">MyBrand</a>

        {{-- Hamburger (mobile) --}}
        <button id="nav-toggle" class="lg:hidden block text-gray-300 hover:text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Menu --}}
        <ul id="nav-menu" class="hidden lg:flex space-x-6 font-medium">
            <li><a href="/" class="hover:text-gray-400">Home</a></li>
            <li><a href="/about" class="hover:text-gray-400">About</a></li>
            <li><a href="/contact" class="hover:text-gray-400">Contact</a></li>
        </ul>
    </div>

    {{-- Menu mobile dropdown --}}
    <div id="nav-dropdown" class="lg:hidden hidden bg-gray-800 px-4 pb-4">
        <a href="/" class="block py-2 hover:text-gray-400">Home</a>
        <a href="/about" class="block py-2 hover:text-gray-400">About</a>
        <a href="/contact" class="block py-2 hover:text-gray-400">Contact</a>
    </div>
</nav>

<script>
    const toggle = document.getElementById('nav-toggle');
    const menu = document.getElementById('nav-menu');
    const dropdown = document.getElementById('nav-dropdown');

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        dropdown.classList.toggle('hidden');
    });
</script>
