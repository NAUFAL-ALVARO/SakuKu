<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ringkasan</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 space-y-6">

    <div class="grid grid-cols-3 gap-4">
        <x-card title="Total Pemasukan" variant="income">
         <p class="text-2xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </x-card>

        <x-card title="Total Pengeluaran" variant="expense">
            <p class="text-2xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </x-card>

        <x-card title="Saldo" variant="default">
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </x-card>
    </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold mb-4">Pemasukan vs Pengeluaran (6 Bulan Terakhir)</h3>
            <canvas id="financeChart" height="100"></canvas>
        </div>

       <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
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
    </script>
</x-app-layout>