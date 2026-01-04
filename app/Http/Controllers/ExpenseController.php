<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repair;
class ExpenseController extends Controller
{
    public function store(Request $request, Repair $repair)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $repair->expenses()->create($request->only('description', 'amount'));

        return back();
    }
}