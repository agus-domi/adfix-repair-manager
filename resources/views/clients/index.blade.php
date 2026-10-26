@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Clientes</h1>
                <p class="text-sm text-slate-500 mt-0.5">Directorio de clientes del taller.</p>
            </div>
            <a href="{{ route('clients.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Cliente
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 text-sm p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 font-semibold">Nombre</th>
                        <th class="px-4 py-3 font-semibold">Teléfono</th>
                        <th class="px-4 py-3 font-semibold text-center">Reparaciones</th>
                        <th class="px-4 py-3 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($clients as $client)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $client->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $client->phone ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="bg-slate-100 text-slate-600 text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $client->repairs_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('clients.show', $client) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                <span class="text-slate-300 mx-1">|</span>
                                <a href="{{ route('clients.edit', $client) }}" class="text-slate-500 hover:text-slate-700 font-medium">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-slate-400">
                                No hay clientes registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $clients->links() }}
        </div>
    </div>
@endsection
