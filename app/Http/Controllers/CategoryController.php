<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori milik user yang sedang login.
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan formulir untuk membuat kategori baru.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'tipe' => 'required|in:income,expense',
        ]);

        Category::create([
            'user_id' => auth()->id(),
            'nama_kategori' => $request->nama_kategori,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit kategori.
     */
    public function edit(Category $category)
    {
        // Proteksi: Pastikan hanya pemilik kategori yang bisa membuka halaman edit
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        return view('categories.edit', compact('category'));
    }

    /**
     * Memperbarui kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        // Proteksi: Pastikan hanya pemilik kategori yang bisa memperbarui
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'tipe' => 'required|in:income,expense',
        ]);

        $category->update($request->only('nama_kategori', 'tipe'));

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(Category $category)
    {
        // Proteksi: Pastikan hanya pemilik kategori yang bisa menghapus
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}