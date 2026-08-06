<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Kategori</h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto sm:px-6">
        <form action="{{ route('categories.store') }}" method="POST" class="bg-white shadow p-6 rounded" x-data="{ loading: false }" @submit="loading = true">
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
           <x-input label="Nama Kategori" name="nama_kategori" required />

            <label class="block mb-2">Tipe</label>
            <select name="tipe" class="w-full border rounded p-2 mb-4" required>
                <option value="income">Pemasukan</option>
                <option value="expense">Pengeluaran</option>
            </select>

            <x-primary-button :disabled="false" x-bind:disabled="loading">
                <span x-show="!loading">Simpan</span>
                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Menyimpan...
                </span>
            </x-primary-button>
        </form>
    </div>
</x-app-layout>