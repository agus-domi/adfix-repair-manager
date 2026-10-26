@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">
                Trabajo #{{ $repair->id }}
            </h1>
            <a href="{{ route('repairs.edit', $repair) }}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                Editar
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <h2 class="text-xs uppercase tracking-wide text-slate-500 font-semibold mb-3">Cliente</h2>
                <p class="text-slate-800 font-medium">{{ $repair->client->name }}</p>
                <p class="text-slate-500 text-sm mt-1">{{ $repair->client->phone ?? 'Sin teléfono' }}</p>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <h2 class="text-xs uppercase tracking-wide text-slate-500 font-semibold mb-3">Equipo</h2>
                <p class="text-slate-800 font-medium">{{ $repair->device }}</p>
                <p class="text-slate-500 text-sm mt-1">{{ $repair->issue }}</p>
                <span class="inline-block mt-3 bg-slate-100 text-slate-600 text-xs font-medium px-2.5 py-1 rounded-full">
                    {{ $repair->status->label() }}
                </span>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 md:col-span-2">
                <h2 class="text-xs uppercase tracking-wide text-slate-500 font-semibold mb-3">Costos</h2>
                <div class="flex flex-wrap gap-8 text-sm">
                    <p><span class="text-slate-500">Presupuesto:</span> <span class="font-medium">${{ number_format($repair->estimated_price, 2) }}</span></p>
                    <p><span class="text-slate-500">Cobrado:</span> <span class="font-medium text-emerald-600">${{ number_format($repair->charged_amount ?? 0, 2) }}</span></p>
                    <p><span class="text-slate-500">Ganancia:</span> <span class="font-medium {{ $repair->profit >= 0 ? 'text-emerald-600' : 'text-red-500' }}">${{ number_format($repair->profit, 2) }}</span></p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Gastos</h2>

            @if ($repair->expenses->count())
                <ul class="mb-4 divide-y divide-slate-100">
                    @foreach ($repair->expenses as $expense)
                        <li class="flex justify-between py-2 text-sm">
                            <span class="text-slate-600">{{ $expense->description }}</span>
                            <span class="font-medium text-red-500">$ {{ number_format($expense->amount, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-slate-400 text-sm mb-4">No hay gastos registrados.</p>
            @endif

            <form method="POST" action="{{ route('expenses.store', $repair) }}" class="flex flex-wrap gap-2">
                @csrf
                <input type="text" name="description" placeholder="Descripción" class="border border-slate-300 rounded-lg px-3 py-2 text-sm w-full md:flex-1 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
                <input type="number" step="0.01" name="amount" placeholder="$" class="border border-slate-300 rounded-lg px-3 py-2 text-sm w-28 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
                <button class="bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-slate-900 transition">
                    Agregar
                </button>
            </form>
        </div>

        <a href="{{ route('repairs.index') }}" class="inline-block mt-6 text-sm text-slate-500 hover:text-slate-700">
            ← Volver
        </a>

    </div>
@endsection
