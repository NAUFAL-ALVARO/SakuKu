<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalIncome = Transaction::where('user_id', $userId)->where('tipe', 'income')->sum('jumlah');
        $totalExpense = Transaction::where('user_id', $userId)->where('tipe', 'expense')->sum('jumlah');
        $saldo = $totalIncome - $totalExpense;

        // Data grafik 6 bulan terakhir
        $chartLabels = [];
        $chartIncome = [];
        $chartExpense = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');

            $chartIncome[] = Transaction::where('user_id', $userId)
                ->where('tipe', 'income')
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('jumlah');

            $chartExpense[] = Transaction::where('user_id', $userId)
                ->where('tipe', 'expense')
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('jumlah');
        }

        $recentTransactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalIncome', 'totalExpense', 'saldo',
            'chartLabels', 'chartIncome', 'chartExpense',
            'recentTransactions'
        ));
    }
}