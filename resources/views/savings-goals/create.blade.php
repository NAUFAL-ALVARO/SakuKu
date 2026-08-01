<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Target Tabungan</h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto sm:px-6">
        <form action="{{ route('savings-goals.store') }}" method="POST" class="bg-white shadow p-6 rounded">
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
            <label class="block mb-2">Nama Target</label>
            <input type="text" name="nama_target" placeholder="Misal: Beli Laptop" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Jumlah Target (Rp)</label>
            <input type="number" step="0.01" name="jumlah_target" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Tenggat Waktu (opsional)</label>
            <input type="date" name="tenggat_waktu" class="w-full border rounded p-2 mb-4">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>