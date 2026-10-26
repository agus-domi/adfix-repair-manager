@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Gastos Generales</h1>
                <p class="text-sm text-slate-500 mt-0.5">Gastos del local y compras no vinculadas a reparaciones.</p>
            </div>
            <a href="{{ route('expenses.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Gasto
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 font-semibold">Fecha</th>
                        <th class="px-4 py-3 font-semibold">Descripción</th>
                        <th class="px-4 py-3 font-semibold text-right">Monto</th>
                        <th class="px-4 py-3 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $expense->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $expense->description }}</td>
                            <td class="px-4 py-3 text-right text-red-500 font-semibold whitespace-nowrap">
                                - ${{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar gasto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-slate-400">
                                No hay gastos generales registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $expenses->links() }}
        </div>
    </div>
@endsection
