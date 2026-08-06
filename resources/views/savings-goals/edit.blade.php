<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Target Tabungan</h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto sm:px-6">
        <form action="{{ route('savings-goals.update', $goal) }}" method="POST" class="bg-white shadow p-6 rounded" x-data="{ submitting: false }" @submit="submitting = true">
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
            <label class="block mb-2">Nama Target</label>
            <input type="text" name="nama_target" value="{{ $goal->nama_target }}" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Jumlah Target (Rp)</label>
            <input type="number" step="0.01" name="jumlah_target" value="{{ $goal->jumlah_target }}" class="w-full border rounded p-2 mb-4" required>

            <label class="block mb-2">Tenggat Waktu (opsional)</label>
            <input type="date" name="tenggat_waktu" value="{{ $goal->tenggat_waktu }}" class="w-full border rounded p-2 mb-4">

            <x-primary-button :disabled="false" x-bind:disabled="submitting">
                <span x-show="!submitting">Update</span>
                <span x-show="submitting" class="flex items-center gap-2">
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