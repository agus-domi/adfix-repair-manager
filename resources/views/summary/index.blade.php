@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">

        <div class="flex justify-between items-end mb-6">
            <h1 class="text-2xl font-bold">Resumen Mensual</h1>
            <form method="GET" class="flex gap-2 items-center">
                <span class="text-gray-600">Mes:</span>
                <input type="month" name="month" value="{{ $month }}" class="border rounded px-3 py-2">
                <button class="bg-gray-800 text-white px-4 py-2 rounded">Filtrar</button>
            </form>
        </div>

        {{-- Dashboard Cards (Contadores globales) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded p-4 flex justify-between items-center">
                <div>
                    <p class="text-blue-600 font-semibold mb-1">Pendientes</p>
                    <h2 class="text-3xl font-bold">{{ $pendingCount }}</h2>
                </div>
                <div class="text-blue-300 text-4xl">
                    <span class="text-4xl text-blue-500">?</span> {{-- Icon placeholder --}}
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded p-4 flex justify-between items-center">
                <div>
                    <p class="text-yellow-600 font-semibold mb-1">En Proceso</p>
                    <h2 class="text-3xl font-bold">{{ $processingCount }}</h2>
                </div>
                <div class="text-yellow-300">
                    <span class="text-4xl text-yellow-500">⚙️</span>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded p-4 flex justify-between items-center">
                <div>
                    <p class="text-green-600 font-semibold mb-1">Completados (Mes)</p>
                    {{-- Aquí podríamos mostrar el contador de completados total, pero usamos la variable pasada del mes
                    actual o general según controlador --}}
                    <h2 class="text-3xl font-bold">{{ $repairs->count() }}</h2>
                </div>
                <div class="text-green-300">
                    <span class="text-4xl text-green-500">✓</span>
                </div>
            </div>
        </div>

        {{-- Financial Cards --}}
        <h3 class="text-lg font-bold mb-4">Finanzas ({{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }})</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white shadow rounded p-4">
                <p class="text-gray-500">Ingresos (Reparaciones)</p>
                <p class="text-2xl font-bold text-green-600">
                    $ {{ number_format($totalIncome, 2) }}
                </p>
            </div>

            <div class="bg-white shadow rounded p-4">
                <p class="text-gray-500">Gastos Totales (Taller + Repuestos)</p>
                <p class="text-2xl font-bold text-red-600">
                    $ {{ number_format($totalExpenses, 2) }}
                </p>
            </div>

            <div class="bg-white shadow rounded p-4">
                <p class="text-gray-500">Ganancia Neta</p>
                <p class="text-2xl font-bold {{ $profit >= 0 ? 'text-gray-800' : 'text-red-500' }}">
                    $ {{ number_format($profit, 2) }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Tabla de Trabajos (Ingresos) --}}
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b font-semibold text-gray-700">Trabajos del Mes</div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-3 py-2">Cliente / Equipo</th>
                            <th class="px-3 py-2 text-right">Cobrado</th>
                            <th class="px-3 py-2 text-right">Gastos</th>
                            <th class="px-3 py-2 text-right">Ganancia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($repairs as $repair)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-3 py-2">
                                    <div class="font-medium">{{ $repair->client->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $repair->device }}</div>
                                </td>
                                <td class="px-3 py-2 text-right text-green-600 font-medium">
                                    $ {{ number_format($repair->charged_amount, 2) }}
                                </td>
                                <td class="px-3 py-2 text-right text-red-600 font-medium">
                                    $ {{ number_format($repair->expenses->sum('amount'), 2) }}
                                </td>
                                <td class="px-3 py-2 text-right">
                                    $ {{ number_format($repair->profit, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">Sin ingresos este mes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Gastos Generales (si hubiera modo de pasarlos detallado, aqui solo tengo el total $generalExpenses.
            Si quiero detallarlos tendría que pasarlos desde el controlador.
            Por ahora mostremos un resumen simple o nada) --}}

            <div class="bg-white shadow rounded p-4">
                <div class="flex justify-between items-center border-b pb-2 mb-2">
                    <h4 class="font-semibold text-gray-700">Desglose de Gastos</h4>
                    <a href="{{ route('expenses.index') }}" class="text-blue-600 text-xs hover:underline">Ver Todo</a>
                </div>

                <div class="flex justify-between py-2 border-b">
                    <span>Repuestos (en reparaciones)</span>
                    <span class="font-medium text-red-600">$
                        {{ number_format($totalExpenses - $generalExpenses, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span>Gastos Generales (Local, etc)</span>
                    <span class="font-medium text-red-600">$ {{ number_format($generalExpenses, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 font-bold pt-2">
                    <span>Total Gastos</span>
                    <span class="text-red-700">$ {{ number_format($totalExpenses, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
@endsection