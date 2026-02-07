<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Provider;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $providerId = $request->provider_id;

        $totalIncomes = Income::query()
            ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
            ->when($providerId, fn($q) => $q->where('provider_id', $providerId))
            ->sum('amount');

        $totalExpenses = Expense::query()
            ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
            ->when($providerId, fn($q) => $q->where('provider_id', $providerId))
            ->sum('amount');

        $grossProfit = $totalIncomes - $totalExpenses;

        $providerIds = Provider::query()
            ->when($providerId, fn($q) => $q->where('id', $providerId))
            ->pluck('id');

        $incomesByProvider = Income::whereIn('provider_id', $providerIds)
            ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
            ->get()
            ->groupBy('provider_id');

        $expensesByProvider = Expense::whereIn('provider_id', $providerIds)
            ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
            ->get()
            ->groupBy('provider_id');

        $providers = Provider::query()
            ->when($providerId, fn($q) => $q->where('id', $providerId))
            ->get()
            ->map(function ($provider) use ($incomesByProvider, $expensesByProvider) {
                $providerIncomes = $incomesByProvider->get($provider->id, collect());
                $providerExpenses = $expensesByProvider->get($provider->id, collect());

                $incomesSum = $providerIncomes->sum('amount');
                $expensesSum = $providerExpenses->sum('amount');

                if ($incomesSum == 0 && $expensesSum == 0) {
                    return null;
                }

                return [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'total_incomes' => $incomesSum,
                    'total_expenses' => $expensesSum,
                    'gross_profit' => $incomesSum - $expensesSum,
                    'incomes' => $providerIncomes->sortByDesc('date')->values(),
                    'expenses' => $providerExpenses->sortByDesc('date')->values(),
                ];
            })
            ->filter();

        $allProviders = Provider::orderBy('name')->get();

        return view('utilities.index', compact(
            'totalIncomes',
            'totalExpenses',
            'grossProfit',
            'providers',
            'allProviders'
        ));
    }
}
