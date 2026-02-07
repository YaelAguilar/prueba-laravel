@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Proveedor</h1>

    <form method="POST" action="{{ route('providers.update', $provider) }}">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Proveedor</label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name', $provider->name) }}"
                class="w-full px-4 py-2 border rounded-lg @error('name') border-red-500 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end space-x-2">
            <a href="{{ route('providers.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
