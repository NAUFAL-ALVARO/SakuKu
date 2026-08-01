<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use Illuminate\Http\Request;

class SavingsGoalController extends Controller
{
    /**
     * Menampilkan daftar target tabungan milik user yang sedang login.
     */
    public function index()
    {
        $goals = SavingsGoal::where('user_id', auth()->id())->latest()->get();
        return view('savings-goals.index', compact('goals'));
    }

    /**
     * Menampilkan formulir tambah target tabungan.
     */
    public function create()
    {
        return view('savings-goals.create');
    }

    /**
     * Menyimpan target tabungan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_target' => 'required|string|max:255',
            'jumlah_target' => 'required|numeric|min:1',
            'tenggat_waktu' => 'nullable|date',
        ]);

        SavingsGoal::create([
            'user_id' => auth()->id(),
            'nama_target' => $request->nama_target,
            'jumlah_target' => $request->jumlah_target,
            'jumlah_terkumpul' => 0,
            'tenggat_waktu' => $request->tenggat_waktu,
            'status' => 'ongoing',
        ]);

        return redirect()->route('savings-goals.index')->with('success', 'Target tabungan berhasil dibuat.');
    }

    /**
     * Menampilkan formulir edit target tabungan.
     */
    public function edit(SavingsGoal $savingsGoal)
    {
        // Proteksi: Cek kepemilikan data
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke target tabungan ini.');
        }

        return view('savings-goals.edit', ['goal' => $savingsGoal]);
    }

    /**
     * Memperbarui target tabungan di database.
     */
    public function update(Request $request, SavingsGoal $savingsGoal)
    {
        // Proteksi: Cek kepemilikan data
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke target tabungan ini.');
        }

        $request->validate([
            'nama_target' => 'required|string|max:255',
            'jumlah_target' => 'required|numeric|min:1',
            'tenggat_waktu' => 'nullable|date',
        ]);

        $savingsGoal->update($request->only('nama_target', 'jumlah_target', 'tenggat_waktu'));

        return redirect()->route('savings-goals.index')->with('success', 'Target tabungan berhasil diperbarui.');
    }

    /**
     * Menghapus target tabungan dari database.
     */
    public function destroy(SavingsGoal $savingsGoal)
    {
        // Proteksi: Cek kepemilikan data
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke target tabungan ini.');
        }

        $savingsGoal->delete();
        return redirect()->route('savings-goals.index')->with('success', 'Target tabungan berhasil dihapus.');
    }

    /**
     * Fitur khusus: menambah jumlah tabungan (Nabung).
     */
    public function nabung(Request $request, SavingsGoal $savingsGoal)
    {
        // Proteksi: Cek kepemilikan data
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke target tabungan ini.');
        }

        $request->validate([
            'jumlah_nabung' => 'required|numeric|min:1',
        ]);

        $savingsGoal->jumlah_terkumpul += $request->jumlah_nabung;

        if ($savingsGoal->jumlah_terkumpul >= $savingsGoal->jumlah_target) {
            $savingsGoal->status = 'achieved';
        }

        $savingsGoal->save();

        return redirect()->route('savings-goals.index')->with('success', 'Berhasil menabung!');
    }
}