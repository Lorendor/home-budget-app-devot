<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="Category management endpoints"
 * )
 */
class CategoryController extends Controller
{
    use ApiResponse;
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(response="200", description="Categories retrieved successfully")
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::orderBy('is_predefined', 'desc')
                                 ->orderBy('name')
                                 ->get();

            return $this->successResponse($categories, 'Categories retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve categories: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Category created successfully")
     * )
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create([
            'name' => $request->name,
            'is_predefined' => false
        ]);

        return $this->successResponse($category, 'Category created successfully', 201);
    }

    public function show(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        return $this->successResponse($category, 'Category retrieved successfully');
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{id}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Category ID"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Category updated successfully"),
     *     @OA\Response(response="403", description="Cannot edit predefined categories")
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if ($category->is_predefined) {
            return $this->errorResponse('Cannot edit predefined categories', 403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category->update($request->only(['name']));

        return $this->successResponse($category, 'Category updated successfully');
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Category ID"),
     *     @OA\Response(response="200", description="Category deleted successfully"),
     *     @OA\Response(response="403", description="Cannot delete predefined categories")
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if ($category->is_predefined) {
            return $this->errorResponse('Cannot delete predefined categories', 403);
        }

        $category->delete();

        return $this->successResponse(null, 'Category deleted successfully');
    }
}
