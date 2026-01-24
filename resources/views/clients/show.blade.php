@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">{{ $client->name }}</h1>
                <p class="text-gray-600">{{ $client->phone ?? 'Sin teléfono registrado' }}</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('clients.edit', $client) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Editar Cliente
                </a>
                <a href="{{ route('clients.index') }}"
                    class="text-gray-600 border border-gray-300 px-4 py-2 rounded hover:bg-gray-50">
                    Volver
                </a>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold mb-4">Historial de Reparaciones ({{ $client->repairs->count() }})</h2>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="pb-2">Fecha</th>
                        <th class="pb-2">Equipo</th>
                        <th class="pb-2">Problema</th>
                        <th class="pb-2">Estado</th>
                        <th class="pb-2 text-right">Monto</th>
                        <th class="pb-2 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->repairs as $repair)
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="py-3 text-sm">{{ $repair->received_at->format('d/m/Y') }}</td>
                            <td class="py-3 font-medium">{{ $repair->device }}</td>
                            <td class="py-3 text-sm text-gray-600">{{ Str::limit($repair->issue, 30) }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($repair->status == 'pendiente') bg-red-100 text-red-800
                                    @elseif($repair->status == 'en_proceso') bg-blue-100 text-blue-800
                                    @elseif($repair->status == 'completado') bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                </span>
                            </td>
                            <td class="py-3 text-right">
                                @if($repair->charged_amount)
                                    ${{ number_format($repair->charged_amount, 2) }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 hover:underline">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">
                                Este cliente no tiene reparaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection