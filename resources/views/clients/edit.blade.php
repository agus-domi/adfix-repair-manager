@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Editar Cliente</h1>
            @if($client->repairs()->count() == 0)
                <form action="{{ route('clients.destroy', $client) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Eliminar</button>
                </form>
            @endif
        </div>

        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Nombre</label>
                    <input type="text" name="name" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        value="{{ old('name', $client->name) }}" required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Teléfono</label>
                    <input type="text" name="phone" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        value="{{ old('phone', $client->phone) }}">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('clients.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium py-2 px-4">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
