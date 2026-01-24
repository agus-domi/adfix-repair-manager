@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Editar Cliente</h1>
            @if($client->repairs()->count() == 0)
                <form action="{{ route('clients.destroy', $client) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 underline text-sm">Eliminar Cliente</button>
                </form>
            @endif
        </div>

        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Nombre</label>
                    <input type="text" name="name" class="w-full border p-2 rounded"
                        value="{{ old('name', $client->name) }}" required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Teléfono</label>
                    <input type="text" name="phone" class="w-full border p-2 rounded"
                        value="{{ old('phone', $client->phone) }}">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('clients.index') }}" class="text-gray-600 hover:underline py-2 px-4">Cancelar</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection