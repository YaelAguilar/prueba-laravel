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

        $providersQuery = Provider::query()
            ->when($providerId, fn($q) => $q->where('id', $providerId));

        $providers = $providersQuery->get()->map(function ($provider) use ($dateFrom, $dateTo) {
            $incomesSum = Income::where('provider_id', $provider->id)
                ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
                ->sum('amount');

            $expensesSum = Expense::where('provider_id', $provider->id)
                ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
                ->sum('amount');

            if ($incomesSum == 0 && $expensesSum == 0) {
                return null;
            }

            $providerIncomes = Income::where('provider_id', $provider->id)
                ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
                ->orderBy('date', 'desc')
                ->get();

            $providerExpenses = Expense::where('provider_id', $provider->id)
                ->when($dateFrom, fn($q) => $q->where('date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->where('date', '<=', $dateTo))
                ->orderBy('date', 'desc')
                ->get();

            return [
                'id' => $provider->id,
                'name' => $provider->name,
                'total_incomes' => $incomesSum,
                'total_expenses' => $expensesSum,
                'gross_profit' => $incomesSum - $expensesSum,
                'incomes' => $providerIncomes,
                'expenses' => $providerExpenses,
            ];
        })->filter();

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
