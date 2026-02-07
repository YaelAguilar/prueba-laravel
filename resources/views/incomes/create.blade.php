@extends('layouts.app')

@section('title', 'Crear Ingreso')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Ingreso</h1>

    <form method="POST" action="{{ route('incomes.store') }}">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Proveedor</label>
            <select 
                name="provider_id" 
                class="w-full px-4 py-2 border rounded-lg @error('provider_id') border-red-500 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
                <option value="">Seleccione un proveedor</option>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                        {{ $provider->name }}
                    </option>
                @endforeach
            </select>
            @error('provider_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Monto</label>
            <input 
                type="number" 
                step="0.01" 
                name="amount" 
                value="{{ old('amount') }}" 
                class="w-full px-4 py-2 border rounded-lg @error('amount') border-red-500 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            @error('amount')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Concepto</label>
            <input 
                type="text" 
                name="concept" 
                value="{{ old('concept') }}" 
                class="w-full px-4 py-2 border rounded-lg @error('concept') border-red-500 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            @error('concept')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
            <input 
                type="date" 
                name="date" 
                value="{{ old('date') }}" 
                class="w-full px-4 py-2 border rounded-lg @error('date') border-red-500 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            @error('date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción (opcional)</label>
            <textarea 
                name="description" 
                rows="3" 
                class="w-full px-4 py-2 border rounded-lg @error('description') border-red-500 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end space-x-2">
            <a href="{{ route('incomes.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Crear
            </button>
        </div>
    </form>
</div>
@endsection
