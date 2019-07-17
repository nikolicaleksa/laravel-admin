<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCategoryRequest;
use Exception;
use App\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private const CATEGORIES_PER_PAGE = 15;


    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only(['deleteCategory', 'addCategory', 'updateCategory']);
    }

    /**
     * Display list of categories.
     *
     * @return View
     */
    public function showCategoriesList(): View
    {
        $categories = Category::withCount(['posts'])->latest()->paginate(self::CATEGORIES_PER_PAGE);

        return view('categories/categories', [
            'categories' => $categories
        ]);
    }

    /**
     * Display add category form.
     *
     * @return View
     */
    public function showAddCategoryForm(): View
    {
        return view('categories/add-category');
    }

    /**
     * Display edit category form.
     *
     * @param Category $category
     *
     * @return View
     */
    public function showEditCategoryForm(Category $category): View
    {
        return view('categories/edit-category', [
            'category' => $category
        ]);
    }

    /**
     * Delete category from the system.
     *
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function deleteCategory(Category $category): JsonResponse
    {
        try {
            $category->delete();
        } catch (Exception $ex) {
            return response()->json([
                'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'response' => trans('messages.failure.unknown-error')
            ]);
        }

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.categories.category-deleted')
        ]);
    }

    /**
     * Add new category.
     *
     * @param SaveCategoryRequest $request
     *
     * @return JsonResponse
     */
    public function addCategory(SaveCategoryRequest $request): JsonResponse
    {
        $categoryData = $request->only(['name']);

        Category::create($categoryData);

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.categories.category-added'),
            'redirect' => route('showCategoriesList')
        ]);
    }

    /**
     * Update existing category information.
     *
     * @param Category $category
     * @param SaveCategoryRequest $request
     *
     * @return JsonResponse
     */
    public function updateCategory(Category $category, SaveCategoryRequest $request): JsonResponse
    {
        $categoryData = $request->only(['name']);

        $category->update($categoryData);

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.success.category-saved'),
            'redirect' => route('showCategoriesList')
        ]);
    }
}
