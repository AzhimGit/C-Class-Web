<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Informatika CFI</title>
    
    @include('partials.theme')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Scrollbar global - Light */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(229,231,235,0.4); border-radius: 3px; }
        ::-webkit-scrollbar-thumb { background: rgba(156,163,175,0.8); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(107,114,128,1); }
        html { scrollbar-width: thin; scrollbar-color: rgba(156,163,175,0.8) rgba(229,231,235,0.4); }

        /* Scrollbar - Dark */
        html.dark ::-webkit-scrollbar-track { background: rgba(31,41,55,0.4); }
        html.dark ::-webkit-scrollbar-thumb { background: rgba(75,85,99,0.8); }
        html.dark ::-webkit-scrollbar-thumb:hover { background: rgba(107,114,128,1); }
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

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gallery-card { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
        .gallery-card:nth-child(1) { animation-delay: 0.05s; }
        .gallery-card:nth-child(2) { animation-delay: 0.1s; }
        .gallery-card:nth-child(3) { animation-delay: 0.15s; }
        .gallery-card:nth-child(4) { animation-delay: 0.2s; }
        .gallery-card:nth-child(5) { animation-delay: 0.25s; }
        .gallery-card:nth-child(6) { animation-delay: 0.3s; }
        .gallery-card:nth-child(n+7) { animation-delay: 0.35s; }

        #lightbox { transition: opacity 0.3s ease; }
        #lightbox.hidden { opacity: 0; pointer-events: none; }
        #lightbox:not(.hidden) { opacity: 1; pointer-events: auto; }

        .gallery-card:hover .gallery-img { transform: scale(1.06); }
        .gallery-img { transition: transform 0.5s ease; will-change: transform; }

        /* Skeleton loader - Light & Dark */
        .skeleton {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        html.dark .skeleton {
            background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
            background-size: 200% 100%;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors">

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

    <main class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-8">

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">Gallery Doksli</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Koleksi Doksli Asli Informatika CFI</p>
                    <p class="text-red-500 dark:text-red-400 text-sm">*dibuat untuk warga yang mulai menyerah mencari doksli</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari judul..."
                               class="w-48 md:w-64 px-4 py-2.5 pl-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition text-sm">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button onclick="openUploadModal()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition shadow-md hover:shadow-lg active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 dark:bg-emerald-900/40 border border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($galleries->count() > 0)
                <div id="galleryGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
                    @foreach($galleries as $index => $item)
                        <div class="gallery-card group bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-600 hover:border-emerald-400 dark:hover:border-emerald-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/10 cursor-pointer"
                             onclick="openLightbox({{ $item->id }}, '{{ asset($item->image) }}', '{{ addslashes($item->title) }}', '{{ $item->created_at->format('d M Y, H:i') }}')"
                             style="animation-delay: {{ $index * 0.05 }}s">

                            <div class="aspect-square overflow-hidden bg-gray-200 dark:bg-gray-700 relative">
                                <div class="absolute inset-0 skeleton"></div>

                                <img src="{{ asset($item->image) }}"
                                     alt="{{ $item->title }}"
                                     loading="lazy"
                                     class="gallery-img w-full h-full object-cover"
                                     onload="this.parentElement.querySelector('.skeleton').style.display='none'">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                    <p class="text-white font-medium text-sm truncate">{{ $item->title }}</p>
                                    <p class="text-gray-300 text-xs">{{ $item->created_at->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="p-3 md:hidden bg-gray-50 dark:bg-gray-700/70">
                                <h4 class="font-medium text-gray-900 dark:text-white text-sm truncate">{{ $item->title }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $item->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-300 dark:border-gray-600">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Gallery masih kosong</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 max-w-sm mx-auto">Mulai koleksi dokumentasi kamu dengan mengupload gambar pertama</p>
                    <button onclick="openUploadModal()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition shadow-md hover:shadow-lg active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload Gambar Pertama
                    </button>
                </div>
            @endif

            @if($galleries instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                @if($galleries->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $galleries->links() }}
                    </div>
                @endif
            @endif
        </div>
    </main>

    <div id="lightbox" class="fixed inset-0 z-[80] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white/70 hover:text-white p-2 rounded-lg hover:bg-white/10 transition z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="relative max-w-5xl w-full max-h-[90vh] flex flex-col items-center">
            <img id="lightboxImg" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl" loading="lazy">

            <div class="mt-4 text-center">
                <h3 id="lightboxTitle" class="text-white font-semibold text-lg"></h3>
                <p id="lightboxDate" class="text-gray-400 text-sm mt-1"></p>
            </div>

            <div class="flex gap-3 mt-4">
                <a id="lightboxDownload" href="" download class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download
                </a>
                <button onclick="copyImageLink()" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Salin Link
                </button>
            </div>
        </div>

        <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-3 rounded-full hover:bg-white/10 transition hidden md:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-3 rounded-full hover:bg-white/10 transition hidden md:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <footer class="bg-gray-100 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-8 mt-auto transition-colors">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <div class="flex justify-center items-center gap-2 mb-4">
                <span class="text-emerald-600 dark:text-emerald-500 font-bold text-xl">❯</span>
                <span class="text-gray-900 dark:text-white font-semibold">Informatika CFI</span>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Platform manajemen tugas & doksli untuk mahasiswa Informatika.</p>
            <div class="flex justify-center items-center gap-2 mb-6">
                <span class="text-gray-500 dark:text-gray-400 text-sm">Dibuat dengan</span>
                <span class="text-red-500 text-lg">❤️</span>
                <span class="text-gray-500 dark:text-gray-400 text-sm">oleh Engginer</span>
            </div>
            <p class="text-gray-500 dark:text-gray-500 text-xs">&copy; {{ date('Y') }} Informatika CFI. All rights reserved.</p>
        </div>
    </footer>

    <div id="uploadModal" class="fixed inset-0 z-[90] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="uploadModalContent">
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Upload Doksli Baru</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tambahkan foto ke galeri kelas</p>
                    </div>
                </div>
                <button onclick="closeUploadModal()" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="uploadForm" action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Judul Foto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="uploadTitle" required maxlength="255"
                        class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                        placeholder="Contoh: Dava lagi ngabuburit">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Gambar <span class="text-red-500">*</span>
                    </label>
                    <div id="dropZone" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center cursor-pointer hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-all duration-200 relative bg-gray-50 dark:bg-gray-800">
                        <input type="file" name="image" id="uploadImage" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        
                        <div id="dropZoneContent" class="pointer-events-none">
                            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span class="text-emerald-600 dark:text-emerald-400 font-medium">Klik untuk pilih</span> atau drag & drop
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WEBP (Maks. 5MB)</p>
                        </div>

                        <div id="imagePreview" class="hidden">
                            <img id="previewImg" src="" alt="Preview" class="max-h-48 mx-auto rounded-lg shadow-lg">
                            <p id="fileName" class="text-xs text-gray-600 dark:text-gray-400 mt-2 truncate"></p>
                            <button type="button" onclick="removeImage(event)" class="mt-2 text-xs text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 font-medium">
                                Hapus gambar
                            </button>
                        </div>
                    </div>
                </div>

                <div id="uploadError" class="hidden p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg text-red-600 dark:text-red-300 text-sm"></div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeUploadModal()"
                            class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white text-sm font-medium rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn"
                            class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span id="submitText">Upload</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        @php
            $galleryJson = $galleries->map(fn($g) => [
                'id' => $g->id,
                'title' => $g->title,
                'image' => asset($g->image),
                'created_at' => $g->created_at->timestamp,
                'date_formatted' => $g->created_at->format('Y-m-d')
            ]);
        @endphp
        const galleryData = @json($galleryJson);

        let currentIndex = 0;
        const items = Array.from(document.querySelectorAll('.gallery-card'));

        function openLightbox(id, src, title, date) {
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightboxImg');
            const titleEl = document.getElementById('lightboxTitle');
            const dateEl = document.getElementById('lightboxDate');
            const downloadLink = document.getElementById('lightboxDownload');

            currentIndex = galleryData.findIndex(item => item.id === id);

            img.src = src;
            img.alt = title;
            titleEl.textContent = title;
            dateEl.textContent = date || '';
            downloadLink.href = src;

            lightbox.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            updateNavButtons();
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function updateNavButtons() {
            document.getElementById('prevBtn').style.display = currentIndex > 0 ? 'block' : 'none';
            document.getElementById('nextBtn').style.display = currentIndex < galleryData.length - 1 ? 'block' : 'none';
        }

        function navigateLightbox(direction) {
            const newIndex = currentIndex + direction;
            if (newIndex >= 0 && newIndex < galleryData.length) {
                const item = galleryData[newIndex];
                openLightbox(item.id, item.image, item.title, new Date(item.created_at * 1000).toLocaleString('id-ID'));
            }
        }

        document.getElementById('prevBtn')?.addEventListener('click', () => navigateLightbox(-1));
        document.getElementById('nextBtn')?.addEventListener('click', () => navigateLightbox(1));
        document.getElementById('lightbox')?.addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') closeLightbox();
        });
        document.addEventListener('keydown', (e) => {
            if (!document.getElementById('lightbox').classList.contains('hidden')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') navigateLightbox(-1);
                if (e.key === 'ArrowRight') navigateLightbox(1);
            }
        });

        function copyImageLink() {
            const src = document.getElementById('lightboxImg').src;
            const isDark = document.documentElement.classList.contains('dark');
            navigator.clipboard.writeText(src).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Link disalin!',
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true,
                    background: isDark ? '#1f2937' : '#ffffff',
                    color: isDark ? '#fff' : '#111827'
                });
            });
        }

        const searchInput = document.getElementById('searchInput');
        const filterSelect = document.getElementById('filterSelect');

        function filterGallery() {
            const query = searchInput.value.toLowerCase();
            const filter = filterSelect?.value;
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
            const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);

            items.forEach((item, index) => {
                const data = galleryData[index];
                if (!data) return;

                const matchesSearch = data.title.toLowerCase().includes(query);
                const itemDate = new Date(data.created_at * 1000);

                let matchesFilter = true;
                if (filter === 'today') matchesFilter = itemDate >= today;
                else if (filter === 'week') matchesFilter = itemDate >= weekAgo;
                else if (filter === 'month') matchesFilter = itemDate >= monthAgo;

                if (matchesSearch && matchesFilter) {
                    item.style.display = '';
                    setTimeout(() => item.style.opacity = '1', 50);
                } else {
                    item.style.opacity = '0';
                    setTimeout(() => item.style.display = 'none', 200);
                }
            });
        }

        searchInput?.addEventListener('input', filterGallery);
        filterSelect?.addEventListener('change', filterGallery);

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    title: 'Hapus gambar ini?',
                    text: 'Tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#4b5563',
                    confirmButtonText: 'Ya, Hapus!',
                    background: isDark ? '#1f2937' : '#ffffff',
                    color: isDark ? '#fff' : '#111827'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        const sidebar = document.getElementById('mobileMenu');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        };

        sidebarToggle?.addEventListener('click', toggleSidebar);
        sidebarClose?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });

        @if(session('success'))
            (() => {
                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true,
                    background: isDark ? '#1f2937' : '#ffffff',
                    color: isDark ? '#fff' : '#111827'
                });
            })();
        @endif

        const uploadModal = document.getElementById('uploadModal');
        const uploadModalContent = document.getElementById('uploadModalContent');
        const uploadForm = document.getElementById('uploadForm');
        const uploadImage = document.getElementById('uploadImage');
        const imagePreview = document.getElementById('imagePreview');
        const dropZoneContent = document.getElementById('dropZoneContent');
        const previewImg = document.getElementById('previewImg');
        const fileName = document.getElementById('fileName');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const uploadError = document.getElementById('uploadError');

        function openUploadModal() {
            uploadModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => {
                uploadModalContent.classList.remove('scale-95', 'opacity-0');
                uploadModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeUploadModal() {
            uploadModalContent.classList.remove('scale-100', 'opacity-100');
            uploadModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                uploadModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                resetUploadForm();
            }, 200);
        }

        function resetUploadForm() {
            uploadForm.reset();
            imagePreview.classList.add('hidden');
            dropZoneContent.classList.remove('hidden');
            uploadError.classList.add('hidden');
            submitBtn.disabled = false;
            submitText.textContent = 'Upload';
        }

        function removeImage(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadImage.value = '';
            imagePreview.classList.add('hidden');
            dropZoneContent.classList.remove('hidden');
        }

        uploadImage.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    uploadError.textContent = 'Ukuran file maksimal 5MB';
                    uploadError.classList.remove('hidden');
                    uploadImage.value = '';
                    return;
                }
                if (!file.type.startsWith('image/')) {
                    uploadError.textContent = 'File harus berupa gambar';
                    uploadError.classList.remove('hidden');
                    uploadImage.value = '';
                    return;
                }

                uploadError.classList.add('hidden');
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                    dropZoneContent.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        const dropZone = document.getElementById('dropZone');
        ['dragenter', 'dragover'].forEach(event => {
            dropZone.addEventListener(event, (e) => {
                e.preventDefault();
                dropZone.classList.add('border-emerald-500');
            });
        });
        ['dragleave', 'drop'].forEach(event => {
            dropZone.addEventListener(event, (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-emerald-500');
            });
        });
        dropZone.addEventListener('drop', (e) => {
            const file = e.dataTransfer.files[0];
            if (file) {
                uploadImage.files = e.dataTransfer.files;
                uploadImage.dispatchEvent(new Event('change'));
            }
        });

        uploadForm.addEventListener('submit', function(e) {
            const title = document.getElementById('uploadTitle').value.trim();
            const image = uploadImage.files[0];
            
            if (!title || !image) {
                e.preventDefault();
                uploadError.textContent = 'Judul dan gambar wajib diisi';
                uploadError.classList.remove('hidden');
                return;
            }

            submitBtn.disabled = true;
            submitText.innerHTML = `
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Uploading...
            `;
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !uploadModal.classList.contains('hidden')) {
                closeUploadModal();
            }
        });
        uploadModal.addEventListener('click', (e) => {
            if (e.target === uploadModal) closeUploadModal();
        });
    </script>
</body>
</html>