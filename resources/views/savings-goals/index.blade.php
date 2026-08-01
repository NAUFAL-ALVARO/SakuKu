<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Target Tabungan</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <a href="{{ route('savings-goals.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Buat Target Baru</a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            @foreach($goals as $goal)
            @php
                $persen = $goal->jumlah_target > 0 ? min(100, ($goal->jumlah_terkumpul / $goal->jumlah_target) * 100) : 0;
            @endphp
            <div class="bg-white shadow rounded p-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold">{{ $goal->nama_target }}</h3>
                    @if($goal->status === 'achieved')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Tercapai 🎉</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">Berjalan</span>
                    @endif
                </div>

                <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                    <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $persen }}%"></div>
                </div>
                <p class="text-sm text-gray-600 mb-1">
                    Rp {{ number_format($goal->jumlah_terkumpul, 0, ',', '.') }} / Rp {{ number_format($goal->jumlah_target, 0, ',', '.') }}
                    ({{ round($persen) }}%)
                </p>
                @if($goal->tenggat_waktu)
                    <p class="text-xs text-gray-500 mb-3">Target selesai: {{ \Carbon\Carbon::parse($goal->tenggat_waktu)->format('d M Y') }}</p>
                @endif

                @if($goal->status !== 'achieved')
                <form action="{{ route('savings-goals.nabung', $goal) }}" method="POST" class="flex gap-2 mb-3">
                    @csrf
                    <input type="number" name="jumlah_nabung" placeholder="Jumlah" class="border rounded p-2 flex-1 text-sm" required min="1">
                    <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded text-sm">Nabung</button>
                </form>
                @endif

                <div class="flex gap-3 text-sm">
                    <a href="{{ route('savings-goals.edit', $goal) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('savings-goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('Yakin hapus target ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>