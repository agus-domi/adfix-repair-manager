@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Nuevo Trabajo</h1>

    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
        <form method="POST" action="{{ route('repairs.store') }}" id="createRepairForm">
            @csrf

            <!-- SECCIÓN CLIENTE -->
            <div class="bg-slate-50 p-4 rounded-lg mb-6 border border-slate-200">
                <h3 class="font-semibold text-slate-700 mb-4">Datos del Cliente</h3>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Buscar Cliente Existente</label>
                    <select name="client_id" id="clientSelect" class="w-full border border-slate-300 p-2 rounded-lg bg-white text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                        <option value="">-- Seleccionar (o dejar vacío para crear nuevo) --</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} - {{ $client->phone }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div id="newClientFields" class="border-t border-slate-200 pt-4 mt-4">
                    <p class="text-sm text-indigo-600 mb-2 font-medium">Creando nuevo cliente:</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="text" name="client_name" id="clientNameInput" placeholder="Nombre completo" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" value="{{ old('client_name') }}">
                            @error('client_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="text" name="client_phone" id="clientPhoneInput" placeholder="Teléfono" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" value="{{ old('client_phone') }}">
                            @error('client_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN EQUIPO -->
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-slate-700">Equipo / Modelo</label>
                <input type="text" name="device" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" placeholder="Ej: iPhone 11, Samsung A52" value="{{ old('device') }}" required>
                @error('device') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-slate-700">Falla / Problema</label>
                <textarea name="issue" rows="3" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" placeholder="Describe el problema..." required>{{ old('issue') }}</textarea>
                @error('issue') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Presupuesto Estimado</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                        <input type="number" step="0.01" name="estimated_price" class="w-full border border-slate-300 p-2 rounded-lg text-sm pl-7 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" placeholder="0.00" value="{{ old('estimated_price') }}" required>
                    </div>
                    @error('estimated_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Estado Inicial</label>
                    <select name="status" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                        @foreach (\App\Enums\RepairStatus::cases() as $option)
                            <option value="{{ $option->value }}" @selected(old('status', 'pendiente') === $option->value)>{{ $option->label() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-1 text-sm font-medium text-slate-700">Fecha de Recepción</label>
                <input type="date" name="received_at" value="{{ old('received_at', date('Y-m-d')) }}" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                @error('received_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('repairs.index') }}" class="text-slate-500 hover:text-slate-700 text-sm font-medium py-2 px-4">Cancelar</a>
                <button type="submit" class="bg-indigo-600 text-white text-sm font-medium px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
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

        function toggleNewClientFields() {
            if (clientSelect.value) {
                newClientFields.style.display = 'none';
            } else {
                newClientFields.style.display = 'block';
            }
        }

        clientSelect.addEventListener('change', toggleNewClientFields);
        toggleNewClientFields();
    });
</script>
@endsection
