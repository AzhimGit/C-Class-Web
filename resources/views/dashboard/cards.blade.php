@extends('layouts.sidebar')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Cards Link Eksternal</h1>
        <p class="text-gray-400 text-sm mt-1">Tambah & kelola link eksternal yang tampil di halaman Cards</p>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-900/40 border border-emerald-700 text-emerald-300 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <form action="{{ route('cards.store') }}" method="POST"
                  class="bg-gray-700/60 rounded-xl border border-gray-600 p-5 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Nama Link <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required maxlength="100"
                        class="w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        placeholder="Contoh: Drive Kelas">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" maxlength="255"
                        class="w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 outline-none transition resize-none"
                        placeholder="Opsional">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Link Eksternal <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="link" value="{{ old('link') }}" required maxlength="255"
                        class="w-full px-3 py-2.5 bg-gray-800 border border-gray-600 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        placeholder="https://...">
                    @error('link') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="w-full px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition">
                    Simpan Card
                </button>
            </form>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-gray-700/60 rounded-xl border border-gray-600 p-5">
                <h3 class="font-semibold text-white mb-4">Semua Card ({{ $cards->count() }})</h3>

                <div class="space-y-2 max-h-[32rem] overflow-y-auto">
                    @forelse($cards as $card)
                    <div class="flex items-center justify-between gap-3 p-3 bg-gray-800 rounded-lg border border-gray-600">
                        <div class="min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ $card->name }}</p>
                            @if($card->description)
                                <p class="text-gray-400 text-xs truncate">{{ $card->description }}</p>
                            @endif
                            <p class="text-emerald-400/80 text-[11px] truncate">{{ $card->link }}</p>
                            <p class="text-gray-500 text-[11px] mt-0.5">oleh {{ $card->user->name ?? 'Unknown' }}</p>
                        </div>

                        @if(in_array(auth()->user()->role, ['admin', 'manager']) || $card->user_id === auth()->id())
                        <form action="{{ route('cards.destroy', $card) }}" method="POST"
                              onsubmit="return confirm('Hapus card ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 p-1.5 hover:bg-red-900/30 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm text-center py-6">Belum ada card. Tambahkan yang pertama!</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection