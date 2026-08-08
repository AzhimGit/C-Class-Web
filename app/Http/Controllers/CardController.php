<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::with('user')->latest()->get();

        return view('cards', compact('cards'));
    }

    public function dashboard()
    {
        $user = auth()->user();

        $cards = Card::with('user')
            ->when($user->role !== 'admin', fn ($q) => $q->where('user_id', $user->id))
            ->latest()
            ->get();

        return view('dashboard.cards', compact('cards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'link'        => 'required|string|max:255',
        ]);

        Card::create([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'link'        => $this->normalizeUrl($validated['link']),
            'user_id'     => auth()->id(),
        ]);

        return back()->with('success', 'Card berhasil ditambahkan!');
    }

    public function update(Request $request, Card $card)
    {
        $this->authorizeCard($card);

        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'link'        => 'required|string|max:255',
        ]);

        $card->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'link'        => $this->normalizeUrl($validated['link']),
        ]);

        return redirect()->route('dashboard.cards')->with('success', 'Card berhasil diperbarui!');
    }

    public function destroy(Card $card)
    {
        $this->authorizeCard($card);

        $card->delete();

        return back()->with('success', 'Card berhasil dihapus!');
    }

    private function authorizeCard(Card $card): void
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $card->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }
    }

    private function normalizeUrl(string $raw): string
    {
        $url = preg_match('#^https?://#i', $raw) ? $raw : 'https://' . ltrim($raw, '/');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            abort(422, 'Format link tidak valid.');
        }

        return $url;
    }
}