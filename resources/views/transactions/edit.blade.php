<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Transaksi</h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto sm:px-6">
        <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="bg-white shadow p-6 rounded" x-data="{ loading: false }" @submit="loading = true">
            @csrf @method('PUT')
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
                <option value="income" {{ $transaction->tipe === 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ $transaction->tipe === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>

            <label class="block mb-2">Kategori</label>
            <select name="category_id" class="w-full border rounded p-2 mb-4" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                @endforeach
            </select>

            <label class="block mb-2">Jumlah (Rp)</label>
            <input type="number" step="0.01" name="jumlah" value="{{ $transaction->jumlah }}" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $transaction->tanggal }}" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Deskripsi (opsional)</label>
            <textarea name="deskripsi" class="w-full border rounded p-2 mb-4">{{ $transaction->deskripsi }}</textarea>

            <x-primary-button :disabled="false" x-bind:disabled="loading">
                <span x-show="!loading">Update</span>
                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Memperbarui...
                </span>
            </x-primary-button>
        </form>
    </div>
</x-app-layout>