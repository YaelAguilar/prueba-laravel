<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Provider;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $incomes = Income::query()
            ->when($request->date_from, fn($q) => $q->where('date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->where('date', '<=', $request->date_to))
            ->when($request->provider_id, fn($q) => $q->where('provider_id', $request->provider_id))
            ->with('provider')
            ->orderBy('date', 'desc')
            ->paginate(15)
            ->withQueryString();

        $providers = Provider::orderBy('name')->get();

        return view('incomes.index', compact('incomes', 'providers'));
    }

    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('incomes.create', compact('providers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'amount' => 'required|numeric|min:0.01',
            'concept' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Income::create($request->only(['provider_id', 'amount', 'concept', 'date', 'description']));

        return redirect()->route('incomes.index')
            ->with('success', 'Ingreso creado exitosamente');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Income $income)
    {
        $providers = Provider::orderBy('name')->get();
        return view('incomes.edit', compact('income', 'providers'));
    }

    public function update(Request $request, Income $income)
    {
        $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'amount' => 'required|numeric|min:0.01',
            'concept' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $income->update($request->only(['provider_id', 'amount', 'concept', 'date', 'description']));

        return redirect()->route('incomes.index')
            ->with('success', 'Ingreso actualizado exitosamente');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index')
            ->with('success', 'Ingreso eliminado exitosamente');
    }
}
