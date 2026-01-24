@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Nuevo Trabajo</h1>

    <div class="bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('repairs.store') }}" id="createRepairForm">
            @csrf

            <!-- SECCIÓN CLIENTE -->
            <div class="bg-gray-50 p-4 rounded mb-6 border">
                <h3 class="font-bold text-gray-700 mb-4">Datos del Cliente</h3>
                
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-semibold text-gray-600">Buscar Cliente Existente</label>
                    <select name="client_id" id="clientSelect" class="w-full border p-2 rounded bg-white">
                        <option value="">-- Seleccionar (o dejar vacío para crear nuevo) --</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} - {{ $client->phone }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div id="newClientFields" class="border-t pt-4 mt-4">
                    <p class="text-sm text-blue-600 mb-2 font-medium">✨ Creando nuevo cliente:</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="text" name="client_name" id="clientNameInput" placeholder="Nombre completo" class="w-full border p-2 rounded" value="{{ old('client_name') }}">
                            @error('client_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="text" name="client_phone" id="clientPhoneInput" placeholder="Teléfono" class="w-full border p-2 rounded" value="{{ old('client_phone') }}">
                            @error('client_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN EQUIPO -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Equipo / Modelo</label>
                <input type="text" name="device" class="w-full border p-2 rounded" placeholder="Ej: iPhone 11, Samsung A52" value="{{ old('device') }}" required>
                @error('device') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Falla / Problema</label>
                <textarea name="issue" rows="3" class="w-full border p-2 rounded" placeholder="Describe el problema..." required>{{ old('issue') }}</textarea>
                @error('issue') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block mb-1 font-semibold">Presupuesto Estimado</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" step="0.01" name="estimated_price" class="w-full border p-2 rounded pl-7" placeholder="0.00" value="{{ old('estimated_price') }}" required>
                    </div>
                    @error('estimated_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Estado Inicial</label>
                    <select name="status" class="w-full border p-2 rounded">
                        <option value="pendiente" {{ old('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_proceso" {{ old('status') == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="completado" {{ old('status') == 'completado' ? 'selected' : '' }}>Completado</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-1 font-semibold">Fecha de Recepción</label>
                <input type="date" name="received_at" value="{{ old('received_at', date('Y-m-d')) }}" class="w-full border p-2 rounded">
                @error('received_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('repairs.index') }}" class="text-gray-600 hover:underline py-2 px-4">Cancelar</a>
                <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800">
                    Guardar Trabajo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clientSelect = document.getElementById('clientSelect');
        const newClientFields = document.getElementById('newClientFields');
        const clientNameInput = document.getElementById('clientNameInput');
        const clientPhoneInput = document.getElementById('clientPhoneInput');

        function toggleNewClientFields() {
            if (clientSelect.value) {
                newClientFields.style.display = 'none';
                // No limpiamos el valor aquí para no perder datos si hay error de validación y vuelve
                // Pero visualmente se oculta.
            } else {
                newClientFields.style.display = 'block';
            }
        }

        clientSelect.addEventListener('change', toggleNewClientFields);
        toggleNewClientFields();
    });
</script>
@endsection