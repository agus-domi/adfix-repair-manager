@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white border border-slate-200 shadow-sm rounded-xl p-6">

        <h1 class="text-xl font-bold text-slate-800 mb-1">
            Cobrar trabajo
        </h1>

        <p class="mb-5 text-slate-500 text-sm">
            {{ $repair->client->name }} — {{ $repair->device }}
        </p>

        <form method="POST" action="{{ route('repairs.storeCharge', $repair) }}">
            @csrf
            @method('PATCH')

            <label class="block mb-1 text-sm font-medium text-slate-700">
                Monto cobrado
            </label>

            <div class="relative mb-4">
                <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                <input type="number" step="0.01" name="charged_amount" class="w-full border border-slate-300 rounded-lg pl-7 pr-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" required>
            </div>
            @error('charged_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <div class="flex justify-between items-center pt-2">
                <a href="{{ route('repairs.index') }}" class="text-slate-500 hover:text-slate-700 text-sm">
                    Cancelar
                </a>

                <button class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Guardar
                </button>
            </div>
        </form>

    </div>
@endsection
