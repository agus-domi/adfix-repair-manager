@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">

        <h1 class="text-2xl font-bold mb-4">
            Trabajo #{{ $repair->id }}
        </h1>

        <div class="bg-white shadow rounded p-4 mb-6">
            <h2 class="font-semibold mb-2">Cliente</h2>
            <p><strong>Nombre:</strong> {{ $repair->client->name }}</p>
            <p><strong>Teléfono:</strong> {{ $repair->client->phone }}</p>
        </div>

        <div class="bg-white shadow rounded p-4 mb-6">
            <h2 class="font-semibold mb-2">Equipo</h2>
            <p><strong>Equipo:</strong> {{ $repair->device }}</p>
            <p><strong>Falla:</strong> {{ $repair->issue }}</p>
            <p><strong>Estado:</strong> {{ $repair->status }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h2 class="font-semibold mb-2">Costos</h2>
            <p><strong>Presupuesto:</strong> ${{ $repair->estimated_price }}</p>
            <p><strong>Cobrado:</strong> ${{ $repair->charged_amount ?? 0 }}</p>
        </div>

        <div class="bg-white shadow rounded p-4 mt-6">
            <h2 class="text-lg font-bold mb-4">Gastos</h2>

            @if ($repair->expenses->count())
                <ul class="mb-4">
                    @foreach ($repair->expenses as $expense)
                        <li class="flex justify-between border-b py-2">
                            <span>{{ $expense->description }}</span>
                            <span>$ {{ number_format($expense->amount, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 mb-4">No hay gastos registrados.</p>
            @endif

            <form method="POST" action="{{ route('expenses.store', $repair) }}" class="flex gap-2">
                @csrf
                <input type="text" name="description" placeholder="Descripción" class="border px-2 py-1 rounded w-full"
                    required>
                <input type="number" step="0.01" name="amount" placeholder="$" class="border px-2 py-1 rounded w-32"
                    required>
                <button class="bg-black text-white px-4 rounded">
                    Agregar
                </button>
            </form>
        </div>


        <a href="{{ route('repairs.index') }}" class="inline-block mt-6 text-blue-600">
            ← Volver
        </a>

    </div>
@endsection