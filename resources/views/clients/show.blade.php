@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $client->name }}</h1>
                <p class="text-slate-500 text-sm mt-0.5">{{ $client->phone ?? 'Sin teléfono registrado' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('clients.index') }}"
                    class="text-slate-600 border border-slate-300 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-50 transition">
                    Volver
                </a>
                <a href="{{ route('clients.edit', $client) }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                    Editar Cliente
                </a>
            </div>
        </div>

        <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Historial de Reparaciones ({{ $client->repairs->count() }})</h2>
            </div>
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 font-semibold">Fecha</th>
                        <th class="px-4 py-3 font-semibold">Equipo</th>
                        <th class="px-4 py-3 font-semibold">Problema</th>
                        <th class="px-4 py-3 font-semibold">Estado</th>
                        <th class="px-4 py-3 font-semibold text-right">Monto</th>
                        <th class="px-4 py-3 font-semibold text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($client->repairs as $repair)
                        @php
                            $statusClasses = match ($repair->status) {
                                \App\Enums\RepairStatus::PENDIENTE => 'bg-slate-100 text-slate-600',
                                \App\Enums\RepairStatus::EN_PROCESO => 'bg-amber-100 text-amber-700',
                                \App\Enums\RepairStatus::COMPLETADO => 'bg-emerald-100 text-emerald-700',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $repair->received_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $repair->device }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ Str::limit($repair->issue, 30) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses }}">
                                    {{ $repair->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if($repair->charged_amount)
                                    ${{ number_format($repair->charged_amount, 2) }}
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('repairs.show', $repair) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                                Este cliente no tiene reparaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
