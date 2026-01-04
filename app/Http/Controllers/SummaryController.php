<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Repair;
use Carbon\Carbon;

class SummaryController extends Controller
{
    public function index()
    {
        $month = request('month', now()->format('Y-m'));

        $repairs = Repair::whereNotNull('paid_amount')
            ->whereMonth('received_at', Carbon::parse($month)->month)
            ->whereYear('received_at', Carbon::parse($month)->year)
            ->with('expenses')
            ->get();

        $totalIncome = $repairs->sum('paid_amount');
        $totalExpenses = $repairs->sum(fn ($r) => $r->expenses->sum('amount'));
        $profit = $totalIncome - $totalExpenses;

        return view('summary.index', compact(
            'month',
            'totalIncome',
            'totalExpenses',
            'profit',
            'repairs'
        ));
    }
}
