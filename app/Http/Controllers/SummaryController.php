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

        // 1. Ingresos y Gastos de Reparaciones (filtrado por fecha de recepción o de cobro?通常 es mejor fecha de cobro para caja, pero el sistema usaba received_at. Mantengamos coherencia o mejoremos.)
        // La logica anterior usaba whereMonth('received_at'). Si queremos ver el flujo de caja real, deberíamos usar 'delivered_at' o 'updated_at' del cobro. 
        // Para simplificar para el usuario principiante, usaremos received_at para "trabajos del mes".

        $repairs = Repair::whereBetween('received_at', [$startOfMonth, $endOfMonth])
            ->with('expenses')
            ->get();

        $repairsIncome = $repairs->sum('charged_amount'); // Usar charged_amount (fix previo)
        $repairsExpenses = $repairs->sum(fn($r) => $r->expenses->sum('amount'));

        // 2. Gastos Generales del mes
        $generalExpenses = Expense::whereNull('repair_id')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Totales
        $totalIncome = $repairsIncome;
        $totalExpenses = $repairsExpenses + $generalExpenses;
        $profit = $totalIncome - $totalExpenses;

        // 3. Contadores para el Dashboard (Estado actual, sin filtro de fecha)
        $pendingCount = Repair::where('status', 'pendiente')->count();
        $processingCount = Repair::where('status', 'en_proceso')->count();
        $completedCount = Repair::where('status', 'completado')->whereNull('delivered_at')->count(); // Listos pero no entregados (si quisieramos esa lógica, sino solo completados)
        // Simplifiquemos: Completados en el mes

        return view('summary.index', compact(
            'month',
            'totalIncome',
            'totalExpenses',
            'profit',
            'repairs',
            'generalExpenses',
            'pendingCount',
            'processingCount'
        ));
    }
}
