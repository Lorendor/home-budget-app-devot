<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

/**
 * @OA\Tag(
 *     name="Income",
 *     description="Income management endpoints"
 * )
 */
class IncomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/incomes",
     *     summary="Get user incomes",
     *     tags={"Income"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response="200", description="Incomes retrieved successfully")
     * )
     */
    public function index()
    {
        $incomes = Income::where('user_id', auth()->id())->get();
        return response()->json($incomes);
    }

    /**
     * @OA\Post(
     *     path="/api/incomes",
     *     summary="Create new income",
     *     tags={"Income"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="source", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Income created successfully")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0.01'
        ]);

        $income = Income::create([
            'user_id' => auth()->id(),
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => now()
        ]);

        $user = auth()->user();
        $user->balance += $request->amount;
        $user->save();

        return response()->json($income, 201);
    }

    public function show($id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($income);
    }

    public function update(Request $request, $id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'description' => 'sometimes|string',
            'amount' => 'sometimes|numeric|min:0.01'
        ]);

        $income->update([
            'description' => $request->description ?? $income->description,
            'amount' => $request->amount ?? $income->amount
        ]);

        return response()->json($income);
    }

    public function destroy($id)
    {
        $income = Income::where('user_id', auth()->id())->findOrFail($id);
        $income->delete();
        return response()->json(['message' => 'Income deleted successfully']);
    }
}
