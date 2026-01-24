@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-6">Registrar Gasto General</h1>

        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('expenses.storeGeneral') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Descripción</label>
                    <input type="text" name="description" class="w-full border p-2 rounded"
                        placeholder="Ej: Alquiler, Luz, Internet" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Monto</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" step="0.01" name="amount" class="w-full border p-2 rounded pl-7" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Fecha</label>
                    <input type="date" name="created_at" class="w-full border p-2 rounded"
                        value="{{ now()->format('Y-m-d') }}" required>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:underline py-2 px-4">Cancelar</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection