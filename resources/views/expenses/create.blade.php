@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Registrar Gasto General</h1>

        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
            <form action="{{ route('expenses.storeGeneral') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Descripción</label>
                    <input type="text" name="description" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        placeholder="Ej: Alquiler, Luz, Internet" required>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Monto</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                        <input type="number" step="0.01" name="amount" class="w-full border border-slate-300 p-2 rounded-lg text-sm pl-7 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
                    </div>
                    @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Fecha</label>
                    <input type="date" name="created_at" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        value="{{ now()->format('Y-m-d') }}" required>
                    @error('created_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('expenses.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium py-2 px-4">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
