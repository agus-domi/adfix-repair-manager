<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Repair;
use App\Models\Expense;
use Carbon\Carbon;

class SummaryController extends Controller
{
    public function index()
    {
        $month = request('month', now()->format('Y-m'));
        $startOfMonth = Carbon::parse($month)->startOfMonth();
        $endOfMonth = Carbon::parse($month)->endOfMonth();

        // Reparaciones entregadas/cobradas en el mes (flujo de caja real)
        $repairs = Repair::whereBetween('delivered_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'completado')
            ->withSum('expenses', 'amount')
            ->get();

        $repairsIncome = $repairs->sum('charged_amount');
        $repairsExpenses = $repairs->sum('expenses_sum_amount');

        // Gastos Generales del mes
        $generalExpenses = Expense::whereNull('repair_id')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Totales
        $totalIncome = $repairsIncome;
        $totalExpenses = $repairsExpenses + $generalExpenses;
        $profit = $totalIncome - $totalExpenses;

        // Contadores para el Dashboard (Estado actual, sin filtro de fecha)
        $pendingCount = Repair::where('status', 'pendiente')->count();
        $processingCount = Repair::where('status', 'en_proceso')->count();
        $completedCount = Repair::where('status', 'completado')->count();

        return view('summary.index', compact(
            'month',
            'totalIncome',
            'totalExpenses',
            'profit',
            'repairs',
            'generalExpenses',
            'pendingCount',
            'processingCount',
            'completedCount'
        ));
    }
}
