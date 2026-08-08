<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards - Informatika CFI</title>
    @include('partials.theme')

    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(229,231,235,0.4); border-radius: 3px; }
        ::-webkit-scrollbar-thumb { background: rgba(156,163,175,0.8); border-radius: 3px; }
        html { scrollbar-width: thin; scrollbar-color: rgba(156,163,175,0.8) rgba(229,231,235,0.4); }
        html.dark ::-webkit-scrollbar-track { background: rgba(31,41,55,0.4); }
        html.dark ::-webkit-scrollbar-thumb { background: rgba(75,85,99,0.8); }
        html.dark { scrollbar-color: rgba(75,85,99,0.8) rgba(31,41,55,0.4); }

        html { scroll-behavior: smooth; }
        body { padding-top: 72px; }

        .nav-underline { position: relative; display: inline-block; }
        .nav-underline::after {
            content: ''; position: absolute; left: 0; bottom: -3px; width: 100%; height: 4px;
            background-color: #10b981; border-radius: 9999px; transform: scaleX(0);
            transform-origin: right; transition: transform 0.3s ease-in-out;
        }
        .nav-underline:hover::after { transform: scaleX(1); transform-origin: left; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .card-item { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }

        /* Favicon wrapper */
        .favicon-wrap {
            position: relative;
            width: 2.25rem;
            height: 2.25rem;
            flex-shrink: 0;
        }
        .favicon-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
            background: #fff;
        }
        .favicon-fallback {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col transition-colors">

    <nav class="fixed top-0 left-0 right-0 h-16 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md text-gray-900 dark:text-white shadow-lg z-50 flex items-center justify-between px-4 md:px-20 transition-all duration-300 border-b border-gray-200 dark:border-gray-700/50">
        <div class="flex items-center gap-4">
            <button id="sidebarToggle" class="md:hidden text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none p-1">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide flex items-center gap-2">
                <span class="text-emerald-600 dark:text-emerald-500">❯</span> Informatika CFI
            </a>
        </div>
        <div class="flex items-center gap-1 md:gap-2">
            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('home') }}" class="nav-underline px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-gray-900 dark:text-white active' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Home</a>
                <a href="{{ route('tasks.public') }}" class="nav-underline px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('tasks.public') ? 'text-gray-900 dark:text-white active' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Task</a>
                <a href="{{ route('galeri') }}" class="nav-underline px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('galeri') ? 'text-gray-900 dark:text-white active' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Gallery</a>
                <a href="{{ route('cards') }}" class="nav-underline px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('cards') ? 'text-gray-900 dark:text-white active' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Cards</a>
                <a href="{{ route('about') }}" class="nav-underline px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'text-gray-900 dark:text-white active' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">About</a>
            </div>
            @include('partials.theme-toggle')
        </div>
    </nav>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden backdrop-blur-sm transition-opacity"></div>
    <div id="mobileMenu" class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 text-gray-900 dark:text-white transform -translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden flex flex-col">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <span class="text-lg font-bold">Menu</span>
            <button id="sidebarClose" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-4 flex flex-col gap-2">
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ request()->routeIs('home') ? 'bg-emerald-600 text-white' : '' }}">Home</a>
            <a href="{{ route('tasks.public') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ request()->routeIs('tasks.public') ? 'bg-emerald-600 text-white' : '' }}">Task</a>
            <a href="{{ route('galeri') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ request()->routeIs('galeri') ? 'bg-emerald-600 text-white' : '' }}">Gallery</a>
            <a href="{{ route('cards') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ request()->routeIs('cards') ? 'bg-emerald-600 text-white' : '' }}">Cards</a>
            <a href="{{ route('about') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ request()->routeIs('about') ? 'bg-emerald-600 text-white' : '' }}">About</a>
        </div>
    </div>

    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
                <div class="flex flex-wrap items-center gap-3 w-full">
                    <div class="relative w-full">
                        <input type="text" id="searchCards" placeholder="Cari card..."
                            class="w-full px-4 py-2.5 pl-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition text-sm">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            @if($cards->count() > 0)
                <div id="cardsGrid" class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($cards as $index => $card)
                        @php $domain = parse_url($card->link, PHP_URL_HOST) ?: 'unknown'; @endphp

                        <a href="{{ $card->link }}" target="_blank" rel="noopener noreferrer"
                           class="card-item group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-emerald-400 dark:hover:border-emerald-500/50 hover:-translate-y-1 transition-all duration-200 shadow-sm flex flex-col gap-2"
                           data-name="{{ strtolower($card->name) }}"
                           data-desc="{{ strtolower($card->description ?? '') }}"
                           data-domain="{{ strtolower($domain) }}"
                           style="animation-delay: {{ $index * 0.03 }}s">
                            <div class="flex items-center justify-between">
                                {{-- Favicon (otomatis) + fallback icon --}}
                                <div class="favicon-wrap">
                                    <img src="https://www.google.com/s2/favicons?domain={{ $domain }}&sz=64"
                                         alt="{{ $domain }}"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="favicon-fallback bg-emerald-100 dark:bg-emerald-900/40">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm truncate">{{ $card->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $card->description }}</p>
                            <span class="text-[11px] text-emerald-600 dark:text-emerald-400 truncate mt-auto">{{ $domain }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Empty state saat search tidak menemukan hasil --}}
                <div id="noResultBox" class="hidden text-center py-20 bg-white dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-300 dark:border-gray-600">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak ada card yang cocok</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Coba kata kunci lain, atau cek ejaan pencarianmu.</p>
                </div>
            @else
                <div class="text-center py-20 bg-white dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-300 dark:border-gray-600">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum ada card</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm max-w-sm mx-auto">
                        Login dan tambahkan link eksternal pertamamu melalui dashboard.
                    </p>
                </div>
            @endif

        </div>
    </main>

    <footer class="bg-gray-100 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-8 mt-auto transition-colors">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <div class="flex justify-center items-center gap-2 mb-4">
                <span class="text-emerald-600 dark:text-emerald-500 font-bold text-xl">❯</span>
                <span class="text-gray-900 dark:text-white font-semibold">Informatika CFI</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Platform manajemen tugas & doksli untuk mahasiswa Informatika.</p>
            <p class="text-gray-500 dark:text-gray-500 text-xs">&copy; {{ date('Y') }} Informatika CFI. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const mobileMenu = document.getElementById('mobileMenu');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        const toggleMenu = () => {
            mobileMenu.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        };

        sidebarToggle?.addEventListener('click', toggleMenu);
        sidebarClose?.addEventListener('click', toggleMenu);
        sidebarOverlay?.addEventListener('click', toggleMenu);

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                mobileMenu.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });

        // ===== SEARCH FILTER =====
        const searchInput = document.getElementById('searchCards');
        const cards = document.querySelectorAll('.card-item');
        const visibleCountEl = document.getElementById('visibleCount');
        const noResultBox = document.getElementById('noResultBox');
        const cardsGrid = document.getElementById('cardsGrid');

        searchInput?.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            let visible = 0;

            cards.forEach(card => {
                const name   = card.dataset.name || '';
                const desc   = card.dataset.desc || '';
                const domain = card.dataset.domain || '';
                const match  = !q || name.includes(q) || desc.includes(q) || domain.includes(q);

                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            if (visibleCountEl) visibleCountEl.textContent = visible;

            if (noResultBox && cardsGrid) {
                if (visible === 0 && q !== '') {
                    noResultBox.classList.remove('hidden');
                    cardsGrid.classList.add('hidden');
                } else {
                    noResultBox.classList.add('hidden');
                    cardsGrid.classList.remove('hidden');
                }
            }
        });
    </script>
</body>
</html>