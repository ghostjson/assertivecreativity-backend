<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VendorAuthMiddleware;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{

    public function __construct()
    {

        $this->middleware([
            AdminAuthMiddleware::class
        ])->only(['store', 'destroy', 'update']);

    }

    /**
     * Get all Categories
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }


    /**
     * Get all products of a specific category
     *
     * @param Category $category
     * @return ResourceCollection
     */
    public function show(Category $category) : ResourceCollection
    {
        return ProductResource::collection(
            Product::where('category', $category->id)
                ->get()
        );
    }

    /**
     * Get all tags associated with a category
     * @param Category $category
     * @return ResourceCollection
     */
    public function tags(Category $category) : ResourceCollection
    {
        return TagResource::collection($category->tags());
    }

    /**
     * Create a new category
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request) : JsonResponse
    {
        Category::create($request->validated());
        return respond('Successfully created category');
    }

    /**
     * update an existing category
     * @param StoreCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(StoreCategoryRequest $request, Category $category) : JsonResponse
    {
        $category->update($request->validated());
        return respond('Successfully updated category');
    }
}
