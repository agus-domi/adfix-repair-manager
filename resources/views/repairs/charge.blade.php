@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow rounded p-6">

    <h1 class="text-xl font-bold mb-4">
        Cobrar trabajo
    </h1>

    <p class="mb-4 text-gray-600">
        {{ $repair->client->name }} — {{ $repair->device }}
    </p>

    <form method="POST" action="{{ route('repairs.storeCharge', $repair) }}">
        @csrf
        @method('PATCH')

        <label class="block mb-2 font-semibold">
            Monto cobrado
        </label>

        <input
            type="number"
            step="0.01"
            name="paid_amount"
            class="border rounded w-full px-3 py-2 mb-4"
            required
        >

        <div class="flex justify-between">
            <a href="{{ route('repairs.index') }}"
               class="text-gray-600">
                Cancelar
            </a>

            <button class="bg-black text-white px-4 py-2 rounded">
                Guardar
            </button>
        </div>
    </form>

</div>
@endsection
