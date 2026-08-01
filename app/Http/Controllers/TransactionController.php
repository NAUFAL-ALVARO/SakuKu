<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi milik user yang sedang login beserta filter.
     */
    public function index(Request $request)
    {
        $query = Transaction::with('category')->where('user_id', auth()->id());

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $transactions = $query->latest('tanggal')->get();

        $totalIncome = Transaction::where('user_id', auth()->id())->where('tipe', 'income')->sum('jumlah');
        $totalExpense = Transaction::where('user_id', auth()->id())->where('tipe', 'expense')->sum('jumlah');

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense'));
    }

    /**
     * Menampilkan formulir tambah transaksi.
     */
    public function create()
    {
        // Hanya mengambil kategori milik user yang sedang login
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('categories'));
    }

    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Proteksi: Memastikan kategori yang dipilih adalah milik user yang sedang login
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'jumlah' => 'required|numeric|min:0',
            'tipe' => 'required|in:income,expense',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'jumlah' => $request->jumlah,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit transaksi.
     */
    public function edit(Transaction $transaction)
    {
        // Proteksi: Cek kepemilikan transaksi
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Memperbarui transaksi di database.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Proteksi: Cek kepemilikan transaksi
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'jumlah' => 'required|numeric|min:0',
            'tipe' => 'required|in:income,expense',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $transaction->update($request->only('category_id', 'jumlah', 'tipe', 'tanggal', 'deskripsi'));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi dari database.
     */
    public function destroy(Transaction $transaction)
    {
        // Proteksi: Cek kepemilikan transaksi
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}