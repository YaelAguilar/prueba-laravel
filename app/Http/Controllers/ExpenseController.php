<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Provider;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::query()
            ->when($request->date_from, fn($q) => $q->where('date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->where('date', '<=', $request->date_to))
            ->when($request->provider_id, fn($q) => $q->where('provider_id', $request->provider_id))
            ->with('provider')
            ->orderBy('date', 'desc')
            ->paginate(15)
            ->withQueryString();

        $providers = Provider::orderBy('name')->get();

        return view('expenses.index', compact('expenses', 'providers'));
    }

    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('expenses.create', compact('providers'));
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

        Expense::create($request->only(['provider_id', 'amount', 'concept', 'date', 'description']));

        return redirect()->route('expenses.index')
            ->with('success', 'Gasto creado exitosamente');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Expense $expense)
    {
        $providers = Provider::orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'providers'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'amount' => 'required|numeric|min:0.01',
            'concept' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense->update($request->only(['provider_id', 'amount', 'concept', 'date', 'description']));

        return redirect()->route('expenses.index')
            ->with('success', 'Gasto actualizado exitosamente');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Gasto eliminado exitosamente');
    }
}
