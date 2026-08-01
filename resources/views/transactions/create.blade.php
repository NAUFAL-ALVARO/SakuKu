<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Transaksi</h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto sm:px-6">
        <form action="{{ route('transactions.store') }}" method="POST" class="bg-white shadow p-6 rounded">
            @csrf
             @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                         @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                         @endforeach
                    </ul>
                 </div>
            @endif
            <label class="block mb-2">Tipe</label>
            <select name="tipe" class="w-full border rounded p-2 mb-4" required>
                <option value="income">Pemasukan</option>
                <option value="expense">Pengeluaran</option>
            </select>

            <label class="block mb-2">Kategori</label>
            <select name="category_id" class="w-full border rounded p-2 mb-4" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama_kategori }} ({{ $category->tipe === 'income' ? 'Pemasukan' : 'Pengeluaran' }})</option>
                @endforeach
            </select>

            <label class="block mb-2">Jumlah (Rp)</label>
            <input type="number" step="0.01" name="jumlah" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Tanggal</label>
            <input type="date" name="tanggal" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Deskripsi (opsional)</label>
            <textarea name="deskripsi" class="w-full border rounded p-2 mb-4"></textarea>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>