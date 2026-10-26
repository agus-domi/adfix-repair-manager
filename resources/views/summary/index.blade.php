@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">

        <div class="flex flex-wrap justify-between items-end gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Resumen Mensual</h1>
                <p class="text-sm text-slate-500 mt-0.5">Ingresos, gastos y ganancias del taller.</p>
            </div>
            <form method="GET" class="flex gap-2 items-center">
                @php
                    $monthNames = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
                    $selectedMonth = \Carbon\Carbon::parse($month)->format('Y-m');
                    $monthOptions = collect(range(0, 23))->map(fn ($i) => now()->startOfMonth()->subMonths($i)->format('Y-m'));
                    if (!$monthOptions->contains($selectedMonth)) {
                        $monthOptions->push($selectedMonth);
                    }
                    $monthOptions = $monthOptions->sortDesc();
                @endphp
                <select name="month" onchange="this.form.submit()"
                    class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                    @foreach ($monthOptions as $value)
                        @php [$year, $monthNumber] = explode('-', $value); @endphp
                        <option value="{{ $value }}" @selected($value === $selectedMonth)>
                            {{ $monthNames[$monthNumber] }} {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Dashboard Cards (Contadores globales) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Pendientes</p>
                    <h2 class="text-3xl font-bold text-slate-800">{{ $pendingCount }}</h2>
                </div>
                <div class="bg-slate-100 text-slate-500 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="text-amber-600 text-sm font-medium mb-1">En Proceso</p>
                    <h2 class="text-3xl font-bold text-slate-800">{{ $processingCount }}</h2>
                </div>
                <div class="bg-amber-100 text-amber-600 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="text-emerald-600 text-sm font-medium mb-1">Completados (Total)</p>
                    <h2 class="text-3xl font-bold text-slate-800">{{ $completedCount }}</h2>
                </div>
                <div class="bg-emerald-100 text-emerald-600 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Financial Cards --}}
        <h3 class="text-lg font-bold text-slate-800 mb-4">Finanzas ({{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }})</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <p class="text-slate-500 text-sm">Ingresos (Reparaciones)</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">
                    $ {{ number_format($totalIncome, 2) }}
                </p>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <p class="text-slate-500 text-sm">Gastos Totales (Taller + Repuestos)</p>
                <p class="text-2xl font-bold text-red-500 mt-1">
                    $ {{ number_format($totalExpenses, 2) }}
                </p>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <p class="text-slate-500 text-sm">Ganancia Neta</p>
                <p class="text-2xl font-bold mt-1 {{ $profit >= 0 ? 'text-slate-800' : 'text-red-500' }}">
                    $ {{ number_format($profit, 2) }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Tabla de Trabajos (Ingresos) --}}
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-200 font-semibold text-slate-700">Trabajos del Mes</div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide text-left">
                            <th class="px-3 py-2 font-semibold">Cliente / Equipo</th>
                            <th class="px-3 py-2 font-semibold text-right">Cobrado</th>
                            <th class="px-3 py-2 font-semibold text-right">Gastos</th>
                            <th class="px-3 py-2 font-semibold text-right">Ganancia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($repairs as $repair)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-3 py-2">
                                    <div class="font-medium text-slate-800">{{ $repair->client->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $repair->device }}</div>
                                </td>
                                <td class="px-3 py-2 text-right text-emerald-600 font-medium whitespace-nowrap">
                                    $ {{ number_format($repair->charged_amount, 2) }}
                                </td>
                                <td class="px-3 py-2 text-right text-red-500 font-medium whitespace-nowrap">
                                    $ {{ number_format($repair->expenses_sum_amount ?? 0, 2) }}
                                </td>
                                <td class="px-3 py-2 text-right text-slate-800 whitespace-nowrap">
                                    $ {{ number_format($repair->profit, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-slate-400">Sin ingresos este mes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                    <h4 class="font-semibold text-slate-700">Desglose de Gastos</h4>
                    <a href="{{ route('expenses.index') }}" class="text-indigo-600 text-xs font-medium hover:underline">Ver Todo</a>
                </div>

                <div class="flex justify-between py-2 border-b border-slate-100 text-sm">
                    <span class="text-slate-600">Repuestos (en reparaciones)</span>
                    <span class="font-medium text-red-500">$
                        {{ number_format($totalExpenses - $generalExpenses, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100 text-sm">
                    <span class="text-slate-600">Gastos Generales (Local, etc)</span>
                    <span class="font-medium text-red-500">$ {{ number_format($generalExpenses, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 pt-3 font-bold text-sm">
                    <span class="text-slate-800">Total Gastos</span>
                    <span class="text-red-600">$ {{ number_format($totalExpenses, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
@endsection
