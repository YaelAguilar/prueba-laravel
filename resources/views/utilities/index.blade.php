@extends('layouts.app')

@section('title', 'Utilidades')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Utilidades</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Filtros</h2>
    <form method="GET" action="{{ route('utilities.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
            <input 
                type="date" 
                name="date_from" 
                value="{{ request('date_from') }}" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
            <input 
                type="date" 
                name="date_to" 
                value="{{ request('date_to') }}" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Proveedor</label>
            <select 
                name="provider_id" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">Todos</option>
                @foreach($allProviders as $provider)
                    <option value="{{ $provider->id }}" {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                        {{ $provider->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Filtrar
            </button>
            @if(request('date_from') || request('date_to') || request('provider_id'))
                <a href="{{ route('utilities.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Limpiar
                </a>
            @endif
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium">Total Ingresos</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">
            ${{ number_format($totalIncomes, 2) }}
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium">Total Gastos</h3>
        <p class="text-3xl font-bold text-red-600 mt-2">
            ${{ number_format($totalExpenses, 2) }}
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-gray-500 text-sm font-medium">Utilidad Bruta</h3>
        <p class="text-3xl font-bold {{ $grossProfit >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
            ${{ number_format($grossProfit, 2) }}
        </p>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ingresos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gastos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilidad Bruta</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($providers as $provider)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $provider['name'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">${{ number_format($provider['total_incomes'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">${{ number_format($provider['total_expenses'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $provider['gross_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format($provider['gross_profit'], 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button 
                            onclick="toggleDetail({{ $provider['id'] }})"
                            class="text-blue-600 hover:text-blue-800"
                            id="btn-{{ $provider['id'] }}"
                        >
                            Ver Detalle
                        </button>
                    </td>
                </tr>
                <tr id="detail-{{ $provider['id'] }}" class="hidden bg-gray-50">
                    <td colspan="5" class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold mb-3 text-green-600">Ingresos</h4>
                                @if($provider['incomes']->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($provider['incomes'] as $income)
                                            <div class="bg-white p-3 rounded border">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="font-medium text-sm">{{ $income->concept }}</p>
                                                        <p class="text-xs text-gray-500">{{ $income->date->format('d/m/Y') }}</p>
                                                        @if($income->description)
                                                            <p class="text-xs text-gray-600 mt-1">{{ $income->description }}</p>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm font-semibold text-green-600">${{ number_format($income->amount, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No hay ingresos registrados</p>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold mb-3 text-red-600">Gastos</h4>
                                @if($provider['expenses']->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($provider['expenses'] as $expense)
                                            <div class="bg-white p-3 rounded border">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="font-medium text-sm">{{ $expense->concept }}</p>
                                                        <p class="text-xs text-gray-500">{{ $expense->date->format('d/m/Y') }}</p>
                                                        @if($expense->description)
                                                            <p class="text-xs text-gray-600 mt-1">{{ $expense->description }}</p>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm font-semibold text-red-600">${{ number_format($expense->amount, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No hay gastos registrados</p>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        No se encontraron datos para los filtros seleccionados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function toggleDetail(providerId) {
    const detailRow = document.getElementById('detail-' + providerId);
    const button = document.getElementById('btn-' + providerId);
    
    if (detailRow.classList.contains('hidden')) {
        detailRow.classList.remove('hidden');
        button.textContent = 'Ocultar Detalle';
    } else {
        detailRow.classList.add('hidden');
        button.textContent = 'Ver Detalle';
    }
}
</script>
@endsection
