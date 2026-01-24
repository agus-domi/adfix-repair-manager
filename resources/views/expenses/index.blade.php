@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gastos Generales</h1>
            <a href="{{ route('expenses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Gasto
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded shadow p-6">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="pb-2">Fecha</th>
                        <th class="pb-2">Descripción</th>
                        <th class="pb-2 text-right">Monto</th>
                        <th class="pb-2 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="py-3">{{ $expense->created_at->format('d/m/Y') }}</td>
                            <td class="py-3">{{ $expense->description }}</td>
                            <td class="py-3 text-right text-red-600 font-semibold">
                                - ${{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="py-3 text-right">
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar gasto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">
                                No hay gastos generales registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection