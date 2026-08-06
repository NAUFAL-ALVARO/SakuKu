<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ringkasan</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 space-y-6">

        <div>
            <h1 class="text-2xl font-semibold text-gray-800">
                @php
                    $hour = now()->format('H');
                    $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
                @endphp
                {{ $greeting }}, {{ explode(' ', Auth::user()->name)[0] }}! 👋
            </h1>
            <p class="text-gray-500 text-sm mt-1">Berikut ringkasan keuangan kamu hari ini.</p>
        </div>

    <div class="grid grid-cols-3 gap-4">
        <x-card title="Total Pemasukan" variant="income">
            <p class="text-2xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            <p class="text-xs mt-1 {{ $incomeChange >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                {{ $incomeChange >= 0 ? '↑' : '↓' }} {{ abs($incomeChange) }}% dari bulan lalu
            </p>
        </x-card>

        <x-card title="Total Pengeluaran" variant="expense">
            <p class="text-2xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            <p class="text-xs mt-1 {{ $expenseChange <= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                {{ $expenseChange >= 0 ? '↑' : '↓' }} {{ abs($expenseChange) }}% dari bulan lalu
            </p>
        </x-card>

        <x-card title="Saldo" variant="default">
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </x-card>
    </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold mb-4">Pemasukan vs Pengeluaran (6 Bulan Terakhir)</h3>
            <canvas id="financeChart" height="100"></canvas>
        </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="font-semibold mb-4">Pengeluaran per Kategori</h3>
            @if($categoryLabels->isEmpty())
                <p class="text-gray-400 text-sm text-center py-8">Belum ada data pengeluaran</p>
            @else
                <div class="flex flex-col items-center gap-4">
                    <div class="w-[140px] h-[140px]">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    <ul class="w-full space-y-2">
                        @php $total = $categoryTotals->sum(); @endphp
                        @foreach($categoryLabels as $i => $label)
                            <li class="flex items-center justify-between text-xs">
                                <span class="flex items-center gap-2 text-gray-600 truncate">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ ['#ef4444','#f97316','#eab308','#8b5cf6','#ec4899','#14b8a6'][$i % 6] }}"></span>
                                    {{ $label }}
                                </span>
                                <span class="font-medium text-gray-700 shrink-0 ml-2">
                                    {{ $total > 0 ? round(($categoryTotals[$i] / $total) * 100) : 0 }}%
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h3 class="font-semibold mb-4">Transaksi Terbaru</h3>

            <x-table :headers="['Tanggal', 'Kategori', 'Jumlah']">
                @foreach($recentTransactions as $trx)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $trx->category->nama_kategori }}</td>
                        <td class="px-4 py-3 text-sm font-medium {{ $trx->tipe === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $trx->tipe === 'income' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('financeChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($chartIncome) !!},
                        backgroundColor: 'rgba(34, 197, 94, 0.7)'
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($chartExpense) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.7)'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top' } }
            }
        });

        @if($categoryLabels->isNotEmpty())
        const ctxCategory = document.getElementById('categoryChart');
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryLabels) !!},
                datasets: [{
                    data: {!! json_encode($categoryTotals) !!},
                    backgroundColor: ['#ef4444','#f97316','#eab308','#8b5cf6','#ec4899','#14b8a6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
        @endif
    </script>
</x-app-layout>