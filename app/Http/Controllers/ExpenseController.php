<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Http\Requests\StoreExpenseRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Expenses",
 *     description="Expense management endpoints"
 * )
 */
class ExpenseController extends Controller
{
    use ApiResponse;
    /**
     * @OA\Get(
     *     path="/api/expenses",
     *     summary="Get user expenses with filtering",
     *     tags={"Expenses"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="category", in="query", description="Filter by category ID"),
     *     @OA\Parameter(name="min_amount", in="query", description="Minimum amount"),
     *     @OA\Parameter(name="max_amount", in="query", description="Maximum amount"),
     *     @OA\Parameter(name="start_date", in="query", description="Start date (YYYY-MM-DD)"),
     *     @OA\Parameter(name="end_date", in="query", description="End date (YYYY-MM-DD)"),
     *     @OA\Parameter(name="search", in="query", description="Search in description"),
     *     @OA\Response(response="200", description="Expenses retrieved successfully")
     * )
     */
    public function index(Request $request)
    {
        $query = Expense::with('category')
            ->where('user_id', auth()->id());

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }
        if ($request->has('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        if ($request->has('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->has('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $expenses = $query->get();

        return $this->successResponse($expenses, 'Expenses retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/expenses",
     *     summary="Create a new expense",
     *     tags={"Expenses"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="categoryId", type="integer")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Expense created successfully")
     * )
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create([
            'user_id' => auth()->id(),
            'category_id' => $request->categoryId,
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date ?? now()
        ]);

        $user = auth()->user();
        $user->balance -= $request->amount;
        $user->save();

        $expense->load('category');

        return $this->successResponse($expense, 'Expense created successfully', 201);
    }

    public function show($id)
    {
        $expense = Expense::with('category')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return $this->successResponse($expense, 'Expense retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'description' => 'sometimes|string',
            'amount' => 'sometimes|numeric|min:0.01',
            'categoryId' => 'sometimes|exists:categories,id'
        ]);

        $expense->update([
            'description' => $request->description ?? $expense->description,
            'amount' => $request->amount ?? $expense->amount,
            'category_id' => $request->categoryId ?? $expense->category_id
        ]);

        $expense->load('category');

        return $this->successResponse($expense, 'Expense updated successfully');
    }

    public function destroy($id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
        $expense->delete();

        return $this->successResponse(null, 'Expense deleted successfully');
    }
}
