<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-gray-200 bg-gray-50">
                @foreach($headers as $header)
                    <th class="px-4 py-3 text-sm font-medium text-gray-500">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            {{ $slot }}
        </tbody>
    </table>

    @if($slot->isEmpty())
        <div class="px-4 py-8 text-center text-gray-400 text-sm">
            Belum ada data
        </div>
    @endif
</div>