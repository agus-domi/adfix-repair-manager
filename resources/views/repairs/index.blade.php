@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Trabajos</h1>

        <a href="{{ route('repairs.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            ➕ Nuevo trabajo
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Cliente</th>
                    <th class="px-4 py-2 text-left">Equipo</th>
                    <th class="px-4 py-2 text-left">Falla</th>
                    <th class="px-4 py-2 text-left">Estado</th>
                    <th class="px-4 py-2 text-left">Ingreso</th>
                    <th class="px-4 py-2 text-left">Ganancia</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($repairs as $repair)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $repair->client->name }}</td>
                        <td class="px-4 py-2">{{ $repair->device }}</td>
                        <td class="px-4 py-2">
                            {{ Str::limit($repair->issue, 30) }}
                        </td>
                        <td class="px-4 py-2">
                            <form method="POST"
                                action="{{ route('repairs.updateStatus', $repair) }}">
                                @csrf
                                @method('PATCH')

                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="border rounded px-2 py-1 text-sm
                                        @if($repair->status === 'pendiente') bg-gray-200
                                        @elseif($repair->status === 'en_proceso') bg-yellow-200
                                        @else bg-green-200 @endif">
                                    <option value="pendiente" @selected($repair->status === 'pendiente')>
                                        Pendiente
                                    </option>
                                    <option value="en_proceso" @selected($repair->status === 'en_proceso')>
                                        En proceso
                                    </option>
                                    <option value="completado" @selected($repair->status === 'completado')>
                                        Completado
                                    </option>
                                </select>
                            </form>
                        </td>

                        <td class="px-4 py-2">
                            {{ $repair->received_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2 font-semibold">
                            $ {{ number_format($repair->profit, 2) }}
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('repairs.show', $repair) }}"
                               class="text-blue-600 hover:underline">
                                Ver
                            </a>
                            <a href="{{ route('repairs.edit', $repair) }}"
                               class="text-yellow-600 hover:underline">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            No hay trabajos cargados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
