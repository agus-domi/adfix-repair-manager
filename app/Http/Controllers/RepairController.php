<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repair;
use App\Models\Client;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairs = Repair::with('client')
            ->orderBy('received_at', 'desc')
            ->get();

        return view('repairs.index', compact('repairs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

        return view('repairs.create', compact('clients'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'nullable|required_without:client_id|string|max:255',
            'client_phone' => 'nullable|required_without:client_id|string|max:50',
            'device' => 'required|string|max:255',
            'issue' => 'required|string',
            'estimated_price' => 'required|numeric|min:0',
            'status' => 'required|in:pendiente,en_proceso,completado',
            'received_at' => 'required|date',
        ]);

        // Si no eligió cliente existente, lo crea
        if (empty($data['client_id'])) {
            $client = Client::create([
                'name' => $data['client_name'],
                'phone' => $data['client_phone'],
            ]);
            $data['client_id'] = $client->id;
        }

        Repair::create([
            'client_id' => $data['client_id'],
            'device' => $data['device'],
            'issue' => $data['issue'],
            'estimated_price' => $data['estimated_price'],
            'status' => $data['status'],
            'received_at' => $data['received_at'],
        ]);

        return redirect()->route('repairs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        $repair->load('client');

        return view('repairs.show', compact('repair'));
    }

    public function updateStatus(Request $request, Repair $repair)
    {
        $request->validate([
            'status' => 'required|in:pendiente,en_proceso,completado',
        ]);

        if ($request->status === 'completado') {
            return redirect()->route('repairs.charge', $repair);
        }

        $repair->update([
            'status' => $request->status,
        ]);

        return back();
    }


    public function charge(Repair $repair)
    {
        return view('repairs.charge', compact('repair'));
    }

    public function storeCharge(Request $request, Repair $repair)
    {
        $request->validate([
            'charged_amount' => 'required|numeric|min:0',
        ]);

        $repair->update([
            'charged_amount' => $request->charged_amount,
            'status' => 'completado',
            'delivered_at' => now(),
        ]);

        return redirect()->route('repairs.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        $clients = Client::orderBy('name')->get();
        return view('repairs.edit', compact('repair', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repair $repair)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'device' => 'required|string|max:255',
            'issue' => 'required|string',
            'estimated_price' => 'required|numeric|min:0',
            'charged_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pendiente,en_proceso,completado',
            'received_at' => 'required|date',
            'delivered_at' => 'nullable|date',
        ]);

        $repair->update($data);

        return redirect()->route('repairs.index')->with('success', 'Reparación actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repair $repair)
    {
        $repair->delete();
        return redirect()->route('repairs.index')->with('success', 'Reparación eliminada.');
    }
}
