<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ringkasan</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 space-y-6">

        <div class="grid grid-cols-3 gap-4">
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
                <p class="text-blue-600 text-xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold mb-4">Pemasukan vs Pengeluaran (6 Bulan Terakhir)</h3>
            <canvas id="financeChart" height="100"></canvas>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="font-semibold mb-4">Transaksi Terbaru</h3>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Kategori</th>
                        <th class="p-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $trx)
                    <tr class="border-b">
                        <td class="p-2">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                        <td class="p-2">{{ $trx->category->nama_kategori }}</td>
                        <td class="p-2 {{ $trx->tipe === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trx->tipe === 'income' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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