@extends('layouts.sidebar')

@section('content')
<div class="p-4 md:p-8 space-y-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Cards Link Eksternal
            </h1>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('cards') }}" target="_blank"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span class="hidden sm:inline">Lihat Halaman Publik</span>
                <span class="sm:hidden">Publik</span>
            </a>
            <button onclick="openAddCardModal()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition shadow-md hover:shadow-emerald-500/20 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Card
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-900/40 border border-emerald-700 text-emerald-300 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @php
        $totalCount = $cards->count();
        $myCount = $cards->where('user_id', auth()->id())->count();
        $todayCount = $cards->where('created_at', '>=', now()->startOfDay())->count();
    @endphp

    <div class="relative w-full">
        <input type="text" id="searchDashboardCards" placeholder="Cari card berdasarkan nama, deskripsi, atau domain..."
            class="w-full px-4 py-2.5 pl-10 bg-gray-800 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </div>

    @if($totalCount > 0)
        <div id="cardsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($cards as $card)
                @php $domain = parse_url($card->link, PHP_URL_HOST) ?: 'unknown'; @endphp
                <div class="card-row group bg-gray-800 rounded-xl border border-gray-600 hover:border-emerald-500/50 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/10 flex flex-col overflow-hidden"
                     data-name="{{ strtolower($card->name) }}"
                     data-desc="{{ strtolower($card->description ?? '') }}"
                     data-domain="{{ strtolower($domain) }}">

                    <div class="p-4 pb-3 flex items-start justify-between gap-2">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center flex-shrink-0 overflow-hidden shadow-sm">
                            <img src="https://www.google.com/s2/favicons?domain={{ $domain }}&sz=64"
                                 alt="{{ $domain }}" loading="lazy"
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <svg class="w-5 h-5 text-emerald-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1">
                            @if($card->user_id === auth()->id())
                                <span class="text-[9px] uppercase tracking-wider font-bold text-emerald-400 bg-emerald-900/40 px-1.5 py-0.5 rounded">Milikmu</span>
                            @endif
                            <a href="{{ $card->link }}" target="_blank" rel="noopener noreferrer"
                               class="p-1.5 hover:bg-gray-700 text-gray-400 hover:text-emerald-400 rounded-lg transition" title="Buka link">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="px-4 flex-1 flex flex-col gap-1">
                        <h3 class="text-white font-semibold text-sm truncate" title="{{ $card->name }}">{{ $card->name }}</h3>
                        <p class="text-gray-400 text-xs line-clamp-2 leading-relaxed min-h-[2rem]">
                            {{ $card->description ?: '—' }}
                        </p>
                    </div>

                    <div class="px-4 py-2.5 bg-gray-900/40 border-t border-gray-700 flex items-center justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider">Oleh</p>
                            <p class="text-xs text-gray-300 truncate">{{ $card->user->name ?? 'Unknown' }}</p>
                        </div>
                        @if(in_array(auth()->user()->role, ['admin', 'manager']) || $card->user_id === auth()->id())
                        <form action="{{ route('cards.destroy', $card) }}" method="POST" class="delete-card-form flex-shrink-0">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 hover:bg-red-900/30 text-gray-400 hover:text-red-400 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div id="noResultList" class="hidden text-center py-16 bg-gray-800/40 rounded-xl border border-dashed border-gray-600">
            <svg class="w-12 h-12 mx-auto text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-400 text-sm">Tidak ada card yang cocok dengan pencarian</p>
        </div>
    @else
        <div class="text-center py-16 bg-gray-800/40 rounded-xl border border-dashed border-gray-600">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            <h3 class="text-xl font-semibold text-white mb-2">Belum ada card</h3>
            <p class="text-gray-400 text-sm mb-6 max-w-sm mx-auto">Mulai dengan menambahkan link eksternal pertamamu.</p>
            <button onclick="openAddCardModal()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Card Pertama
            </button>
        </div>
    @endif

</div>

<div id="addCardModal" class="fixed inset-0 z-[90] hidden flex items-end sm:items-center justify-center">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-md opacity-0 transition-opacity duration-300" onclick="closeAddCardModal()"></div>

    <div class="relative w-full sm:max-w-lg mx-0 sm:mx-4 bg-gray-800 sm:rounded-2xl rounded-t-2xl border-0 sm:border border-gray-700 shadow-2xl flex flex-col overflow-hidden max-h-[90vh] sm:max-h-[85vh] opacity-0 translate-y-full sm:translate-y-4 sm:scale-95 transition-all duration-300 ease-out" id="addCardModalPanel">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-700 bg-gray-900/50 flex-shrink-0">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Card Baru
            </h3>
            <button onclick="closeAddCardModal()" class="text-gray-400 hover:text-white transition p-2 hover:bg-gray-700 rounded-lg -mr-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="{{ route('cards.store') }}" method="POST" id="cardForm" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Nama Link <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required maxlength="100"
                    class="w-full px-3 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    placeholder="Contoh: Drive Kelas">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi Singkat</label>
                <textarea name="description" id="modalDesc" rows="3" maxlength="255"
                    class="w-full px-3 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 outline-none transition resize-none"
                    placeholder="Opsional, maks 255 karakter">{{ old('description') }}</textarea>
                <div class="flex justify-between items-center mt-1">
                    @error('description') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                    <p class="text-[10px] text-gray-500 ml-auto"><span id="modalDescCount">0</span>/255</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Link Eksternal <span class="text-red-400">*</span>
                </label>
                <input type="text" name="link" value="{{ old('link') }}" required maxlength="255"
                    class="w-full px-3 py-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    placeholder="https://...">
                @error('link') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2 pt-2">
                <button type="button" onclick="closeAddCardModal()"
                        class="flex-1 px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Card
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const addCardModal = document.getElementById('addCardModal');
    const addCardPanel = document.getElementById('addCardModalPanel');

    function openAddCardModal() {
        addCardModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        requestAnimationFrame(() => {
            addCardModal.querySelector('.absolute').classList.remove('opacity-0');
            addCardPanel.classList.remove('opacity-0', 'translate-y-full', 'sm:translate-y-4', 'sm:scale-95');
        });
    }

    function closeAddCardModal() {
        addCardModal.querySelector('.absolute').classList.add('opacity-0');
        addCardPanel.classList.add('opacity-0', 'translate-y-full', 'sm:translate-y-4', 'sm:scale-95');
        setTimeout(() => {
            addCardModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    @if($errors->any() && old('name') !== null)
        document.addEventListener('DOMContentLoaded', openAddCardModal);
    @endif

    const modalDesc = document.getElementById('modalDesc');
    const modalDescCount = document.getElementById('modalDescCount');
    modalDesc?.addEventListener('input', () => {
        modalDescCount.textContent = modalDesc.value.length;
    });
    if (modalDesc?.value) modalDescCount.textContent = modalDesc.value.length;

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !addCardModal.classList.contains('hidden')) {
            closeAddCardModal();
        }
    });

    const searchInput = document.getElementById('searchDashboardCards');
    const cards = document.querySelectorAll('.card-row');
    const noResult = document.getElementById('noResultList');
    const grid = document.getElementById('cardsGrid');

    searchInput?.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase().trim();
        let visible = 0;
        cards.forEach(card => {
            const match = !q ||
                (card.dataset.name || '').includes(q) ||
                (card.dataset.desc || '').includes(q) ||
                (card.dataset.domain || '').includes(q);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        if (noResult && grid) {
            noResult.classList.toggle('hidden', !(visible === 0 && q));
            grid.classList.toggle('hidden', visible === 0 && q !== '');
        }
    });

    document.querySelectorAll('.delete-card-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus card ini?',
                text: 'Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4b5563',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1f2937',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>
@endpush
@endsection