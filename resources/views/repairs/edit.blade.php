@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Editar Reparación #{{ $repair->id }}</h1>
            <form action="{{ route('repairs.destroy', $repair) }}" method="POST"
                onsubmit="return confirm('¿Estás seguro? Se borrarán también los gastos asociados.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg hover:bg-red-100 text-sm font-medium transition">
                    Eliminar
                </button>
            </form>
        </div>

        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
            <form action="{{ route('repairs.update', $repair) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Cliente</label>
                    <select name="client_id" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
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
                        <label class="block mb-1 text-sm font-medium text-slate-700">Equipo</label>
                        <input type="text" name="device" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                            value="{{ old('device', $repair->device) }}" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Fecha Recepción</label>
                        <input type="date" name="received_at" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                            value="{{ old('received_at', $repair->received_at->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Problema / Detalle</label>
                    <textarea name="issue" rows="3" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        required>{{ old('issue', $repair->issue) }}</textarea>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Estado</label>
                        <select name="status" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                            @foreach (\App\Enums\RepairStatus::cases() as $option)
                                <option value="{{ $option->value }}" @selected($repair->status === $option)>
                                    {{ $option->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Precio Estimado</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" name="estimated_price" class="w-full border border-slate-300 p-2 rounded-lg text-sm pl-7 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                                value="{{ old('estimated_price', $repair->estimated_price) }}">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Cobrado (Final)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" name="charged_amount" class="w-full border border-slate-300 p-2 rounded-lg text-sm pl-7 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                                value="{{ old('charged_amount', $repair->charged_amount) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 text-sm font-medium text-slate-700">Fecha Entrega (Opcional)</label>
                    <input type="date" name="delivered_at" class="w-full border border-slate-300 p-2 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                        value="{{ old('delivered_at', $repair->delivered_at?->format('Y-m-d')) }}">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('repairs.show', $repair) }}"
                        class="text-slate-500 hover:text-slate-700 text-sm font-medium py-2 px-4">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
