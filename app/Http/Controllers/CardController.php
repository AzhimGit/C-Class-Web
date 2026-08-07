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
        $cards = Card::with('user')->latest()->get();

        return view('dashboard.cards', compact('cards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'link'        => 'required|string|max:255',
        ]);

        $url = $validated['link'];
        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return back()->withInput()->withErrors(['link' => 'Format link tidak valid.']);
        }

        Card::create([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'link'        => $url,
            'user_id'     => auth()->id(),
        ]);

        return back()->with('success', 'Card berhasil ditambahkan!');
    }

    public function destroy(Card $card)
    {
        $user = auth()->user();

        if ($card->user_id !== $user->id && !in_array($user->role, ['admin', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        $card->delete();

        return back()->with('success', 'Card berhasil dihapus!');
    }
}