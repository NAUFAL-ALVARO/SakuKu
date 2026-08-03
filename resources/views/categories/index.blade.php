<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kategori</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Kategori</a>

        <x-table :headers="['Nama Kategori', 'Tipe', 'Aksi']">
            @foreach($categories as $category)
                <tr class="border-b">
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $category->nama_kategori }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs {{ $category->tipe === 'income' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $category->tipe === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 mr-3">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
</x-app-layout>