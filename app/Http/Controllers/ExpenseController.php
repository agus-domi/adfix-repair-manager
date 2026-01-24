<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Repair;

class ExpenseController extends Controller
{
    public function index()
    {
        // Gastos generales (no vinculados a reparaciones)
        $expenses = Expense::whereNull('repair_id')->orderBy('created_at', 'desc')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    // Guardar gasto general (o vinculado si se envía repair_id explícitamente, pero por ahora lo separo)
    public function storeGeneral(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'created_at' => 'required|date',
        ]);

        Expense::create($data); // repair_id será null por defecto

        return redirect()->route('expenses.index')->with('success', 'Gasto registrado.');
    }

    // Guardar gasto de reparación (ruta anidada)
    public function store(Request $request, Repair $repair)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $repair->expenses()->create($data);

        return back()->with('success', 'Gasto agregado a la reparación.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Gasto eliminado.');
    }
}