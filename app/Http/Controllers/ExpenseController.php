<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function index()
    {
        $expenses = Expense::with('category')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json($expenses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'categoryId' => 'required|exists:categories,id'
        ]);

        $expense = Expense::create([
            'user_id' => auth()->id(),
            'category_id' => $request->categoryId,
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => now()
        ]);

        $expense->load('category');

        return response()->json($expense, 201);
    }

    public function show($id)
    {
        $expense = Expense::with('category')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($expense);
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

        return response()->json($expense);
    }

    public function destroy($id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully']);
    }
}