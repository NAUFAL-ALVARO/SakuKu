<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white shadow rounded p-4">
                <p class="text-gray-500 text-sm">Total Pemasukan</p>
                <p class="text-green-600 text-xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow rounded p-4">
                <p class="text-gray-500 text-sm">Total Pengeluaran</p>
                <p class="text-red-600 text-xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow rounded p-4">
                <p class="text-gray-500 text-sm">Saldo</p>
                <p class="text-blue-600 text-xl font-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</p>
            </div>
        </div>

        <a href="{{ route('transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Transaksi</a>

        <table class="w-full bg-white shadow rounded mt-4">
            <thead>
                <tr class="border-b text-left">
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Tipe</th>
                    <th class="p-3">Jumlah</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr class="border-b">
                    <td class="p-3">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                    <td class="p-3">{{ $trx->category->nama_kategori }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs {{ $trx->tipe === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $trx->tipe === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="p-3">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                    <td class="p-3">{{ $trx->deskripsi }}</td>
                    <td class="p-3">
                        <a href="{{ route('transactions.edit', $trx) }}" class="text-blue-600 mr-3">Edit</a>
                        <form action="{{ route('transactions.destroy', $trx) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>