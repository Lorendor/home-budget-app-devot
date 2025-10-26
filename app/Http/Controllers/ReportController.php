<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function overview()
    {
        $user = auth()->user();
        
        $totalIncome = Income::where('user_id', $user->id)->sum('amount');
        $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');
        
        return response()->json([
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'current_balance' => $totalIncome - $totalExpenses
        ]);
    }

    public function monthly()
    {
        $user = auth()->user();
        
        $income = Income::where('user_id', $user->id)
                    ->where('date', '>=', Carbon::now()->subDays(30))
                    ->sum('amount');
                    
        $expenses = Expense::where('user_id', $user->id)
                      ->where('date', '>=', Carbon::now()->subDays(30))
                      ->sum('amount');
        
        return response()->json([
            'period' => 'last_30_days',
            'income' => $income,
            'expenses' => $expenses,
            'net' => $income - $expenses
        ]);
    }

    public function quarterly()
    {
        $user = auth()->user();
        
        $income = Income::where('user_id', $user->id)
                    ->where('date', '>=', Carbon::now()->subMonths(3))
                    ->sum('amount');
                    
        $expenses = Expense::where('user_id', $user->id)
                      ->where('date', '>=', Carbon::now()->subMonths(3))
                      ->sum('amount');
        
        return response()->json([
            'period' => 'last_3_months',
            'income' => $income,
            'expenses' => $expenses,
            'net' => $income - $expenses
        ]);
    }

    public function yearly()
    {
        $user = auth()->user();
        
        $income = Income::where('user_id', $user->id)
                    ->where('date', '>=', Carbon::now()->subYear())
                    ->sum('amount');
                    
        $expenses = Expense::where('user_id', $user->id)
                      ->where('date', '>=', Carbon::now()->subYear())
                      ->sum('amount');
        
        return response()->json([
            'period' => 'last_12_months',
            'income' => $income,
            'expenses' => $expenses,
            'net' => $income - $expenses
        ]);
    }
}