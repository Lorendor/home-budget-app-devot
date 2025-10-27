<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Reports",
 *     description="Data aggregation and reporting endpoints"
 * )
 */
class ReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reports/overview",
     *     summary="Get financial overview",
     *     tags={"Reports"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Overview retrieved successfully")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/reports/monthly",
     *     summary="Get monthly reports",
     *     tags={"Reports"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Monthly reports retrieved successfully")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/reports/quarterly",
     *     summary="Get quarterly reports",
     *     tags={"Reports"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Quarterly reports retrieved successfully")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/reports/yearly",
     *     summary="Get yearly reports",
     *     tags={"Reports"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Yearly reports retrieved successfully")
     * )
     */
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
