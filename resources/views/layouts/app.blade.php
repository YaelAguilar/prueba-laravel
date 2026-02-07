<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Módulo de Utilidades')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navegación -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex space-x-8 items-center">
                    <a href="{{ route('utilities.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Utilidades
                    </a>
                    <a href="{{ route('providers.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Proveedores
                    </a>
                    <a href="{{ route('incomes.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Ingresos
                    </a>
                    <a href="{{ route('expenses.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Gastos
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mensajes flash -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Contenido principal -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>
</html>
