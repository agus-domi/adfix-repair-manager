@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Editar Reparación #{{ $repair->id }}</h1>
            <form action="{{ route('repairs.destroy', $repair) }}" method="POST"
                onsubmit="return confirm('¿Estás seguro? Se borrarán también los gastos asociados.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                    Eliminar Reparación
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('repairs.update', $repair) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Cliente -->
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Cliente</label>
                    <select name="client_id" class="w-full border p-2 rounded bg-gray-50">
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $repair->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-1 font-semibold">Equipo</label>
                        <input type="text" name="device" class="w-full border p-2 rounded"
                            value="{{ old('device', $repair->device) }}" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Fecha Recepción</label>
                        <input type="date" name="received_at" class="w-full border p-2 rounded"
                            value="{{ old('received_at', $repair->received_at->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Problema / Detalle</label>
                    <textarea name="issue" rows="3" class="w-full border p-2 rounded"
                        required>{{ old('issue', $repair->issue) }}</textarea>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block mb-1 font-semibold">Estado</label>
                        <select name="status" class="w-full border p-2 rounded">
                            <option value="pendiente" {{ $repair->status == 'pendiente' ? 'selected' : '' }}>Pendiente
                            </option>
                            <option value="en_proceso" {{ $repair->status == 'en_proceso' ? 'selected' : '' }}>En Proceso
                            </option>
                            <option value="completado" {{ $repair->status == 'completado' ? 'selected' : '' }}>Completado
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Precio Estimado</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input type="number" step="0.01" name="estimated_price" class="w-full border p-2 rounded pl-7"
                                value="{{ old('estimated_price', $repair->estimated_price) }}">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Cobrado (Final)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">$</span>
                            <input type="number" step="0.01" name="charged_amount" class="w-full border p-2 rounded pl-7"
                                value="{{ old('charged_amount', $repair->charged_amount) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 font-semibold">Fecha Entrega (Opcional)</label>
                    <input type="date" name="delivered_at" class="w-full border p-2 rounded"
                        value="{{ old('delivered_at', $repair->delivered_at?->format('Y-m-d')) }}">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('repairs.show', $repair) }}"
                        class="text-gray-600 hover:underline py-2 px-4">Cancelar</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection