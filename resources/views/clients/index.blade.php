@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Clientes</h1>
            <a href="{{ route('clients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Cliente
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded shadow p-6">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="pb-2">Nombre</th>
                        <th class="pb-2">Teléfono</th>
                        <th class="pb-2 text-center">Reparaciones</th>
                        <th class="pb-2 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="py-3">{{ $client->name }}</td>
                            <td class="py-3">{{ $client->phone ?? '-' }}</td>
                            <td class="py-3 text-center">
                                <span class="bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full">
                                    {{ $client->repairs_count }}
                                </span>
                            </td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('clients.edit', $client) }}"
                                    class="text-yellow-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">
                                No hay clientes registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection