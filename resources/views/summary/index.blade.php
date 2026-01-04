@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        Resumen mensual
    </h1>

    {{-- Selector de mes --}}
    <form method="GET" class="mb-6">
        <input
            type="month"
            name="month"
            value="{{ $month }}"
            class="border rounded px-3 py-2"
        >
        <button class="bg-black text-white px-4 py-2 rounded ml-2">
            Ver
        </button>
    </form>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white shadow rounded p-4">
            <p class="text-gray-500">Ingresos</p>
            <p class="text-2xl font-bold text-green-600">
                $ {{ number_format($totalIncome, 2) }}
            </p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-gray-500">Gastos</p>
            <p class="text-2xl font-bold text-red-600">
                $ {{ number_format($totalExpenses, 2) }}
            </p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-gray-500">Ganancia</p>
            <p class="text-2xl font-bold">
                $ {{ number_format($profit, 2) }}
            </p>
        </div>
    </div>

    {{-- Tabla de trabajos --}}
    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Cliente</th>
                    <th class="px-4 py-2 text-left">Equipo</th>
                    <th class="px-4 py-2 text-left">Cobrado</th>
                    <th class="px-4 py-2 text-left">Gastos</th>
                    <th class="px-4 py-2 text-left">Ganancia</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($repairs as $repair)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $repair->client->name }}</td>
                        <td class="px-4 py-2">{{ $repair->device }}</td>
                        <td class="px-4 py-2">
                            $ {{ number_format($repair->paid_amount, 2) }}
                        </td>
                        <td class="px-4 py-2">
                            $ {{ number_format($repair->expenses->sum('amount'), 2) }}
                        </td>
                        <td class="px-4 py-2 font-semibold">
                            $ {{ number_format($repair->profit, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            No hay datos para este mes.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
