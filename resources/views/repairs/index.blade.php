@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Trabajos</h1>
            <p class="text-sm text-slate-500 mt-0.5">Gestiona las reparaciones del taller.</p>
        </div>

        <a href="{{ route('repairs.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo trabajo
        </a>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                    <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                    <th class="px-4 py-3 text-left font-semibold">Equipo</th>
                    <th class="px-4 py-3 text-left font-semibold">Falla</th>
                    <th class="px-4 py-3 text-left font-semibold">Estado</th>
                    <th class="px-4 py-3 text-left font-semibold">Ingreso</th>
                    <th class="px-4 py-3 text-left font-semibold">Ganancia</th>
                    <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($repairs as $repair)
                    @php
                        $status = $repair->status;
                        $statusClasses = match ($status) {
                            \App\Enums\RepairStatus::PENDIENTE => 'bg-slate-100 text-slate-600',
                            \App\Enums\RepairStatus::EN_PROCESO => 'bg-amber-100 text-amber-700',
                            \App\Enums\RepairStatus::COMPLETADO => 'bg-emerald-100 text-emerald-700',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $repair->client->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $repair->device }}</td>
                        <td class="px-4 py-3 text-slate-500">
                            {{ Str::limit($repair->issue, 30) }}
                        </td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('repairs.updateStatus', $repair) }}">
                                @csrf
                                @method('PATCH')

                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-full border-0 appearance-none pl-3 pr-7 py-1 text-xs font-medium cursor-pointer focus:ring-2 focus:ring-indigo-200 {{ $statusClasses }}"
                                        style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 0.4rem center; background-size: 0.75rem;">
                                    @foreach (\App\Enums\RepairStatus::cases() as $option)
                                        <option value="{{ $option->value }}" @selected($status === $option)>
                                            {{ $option->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>

                        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                            {{ $repair->received_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 font-semibold whitespace-nowrap {{ $repair->profit >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            $ {{ number_format($repair->profit, 2) }}
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('repairs.show', $repair) }}"
                               class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Ver
                            </a>
                            <span class="text-slate-300 mx-1">|</span>
                            <a href="{{ route('repairs.edit', $repair) }}"
                               class="text-slate-500 hover:text-slate-700 font-medium">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                            No hay trabajos cargados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $repairs->links() }}
    </div>

</div>
@endsection
