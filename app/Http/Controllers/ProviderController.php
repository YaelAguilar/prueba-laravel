<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $providers = Provider::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:providers,name',
        ]);

        Provider::create($request->only('name'));

        return redirect()->route('providers.index')
            ->with('success', 'Proveedor creado exitosamente');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:providers,name,' . $provider->id,
        ]);

        $provider->update($request->only('name'));

        return redirect()->route('providers.index')
            ->with('success', 'Proveedor actualizado exitosamente');
    }

    public function destroy(Provider $provider)
    {
        if ($provider->incomes()->count() > 0 || $provider->expenses()->count() > 0) {
            return redirect()->route('providers.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene ingresos o gastos asociados');
        }

        $provider->delete();

        return redirect()->route('providers.index')
            ->with('success', 'Proveedor eliminado exitosamente');
    }
}
