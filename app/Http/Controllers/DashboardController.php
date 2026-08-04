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

        // Perbandingan bulan ini vs bulan lalu
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();

        $thisMonthIncome = Transaction::where('user_id', $userId)->where('tipe', 'income')
            ->whereMonth('tanggal', $now->month)->whereYear('tanggal', $now->year)->sum('jumlah');
        $lastMonthIncome = Transaction::where('user_id', $userId)->where('tipe', 'income')
            ->whereMonth('tanggal', $lastMonth->month)->whereYear('tanggal', $lastMonth->year)->sum('jumlah');

        $thisMonthExpense = Transaction::where('user_id', $userId)->where('tipe', 'expense')
            ->whereMonth('tanggal', $now->month)->whereYear('tanggal', $now->year)->sum('jumlah');
        $lastMonthExpense = Transaction::where('user_id', $userId)->where('tipe', 'expense')
            ->whereMonth('tanggal', $lastMonth->month)->whereYear('tanggal', $lastMonth->year)->sum('jumlah');

        $incomeChange = $lastMonthIncome > 0
            ? round((($thisMonthIncome - $lastMonthIncome) / $lastMonthIncome) * 100)
            : ($thisMonthIncome > 0 ? 100 : 0);

        $expenseChange = $lastMonthExpense > 0
            ? round((($thisMonthExpense - $lastMonthExpense) / $lastMonthExpense) * 100)
            : ($thisMonthExpense > 0 ? 100 : 0);

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
            'recentTransactions',
            'incomeChange', 'expenseChange'
        ));
    }
}