<?php

namespace App\Http\Controllers\CustomProduct;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\GetProductByCategoriesRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CustomProductResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\CustomProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomCategoryController extends Controller
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
     *s
     * @param Category $category
     * @return ResourceCollection
     */
    public function show(Category $category) : ResourceCollection
    {
        return CustomProductResource::collection(
            CustomProduct::where('category_id', $category->id)
                ->get()
        );
    }

    /**
     * Get products from list of categories
     * @param GetProductByCategoriesRequest $request
     * @return ResourceCollection
     */
    public function getProductByCategories(GetProductByCategoriesRequest $request) : ResourceCollection
    {
        $ids = json_decode(json_encode($request->validated()['category_ids']));
        return CustomProductResource::collection(CustomProduct::whereIn('category_id', $ids)->get());

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
        $category = Category::create($request->validated());
        return respondWithObject('Successfully created category', $category);
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
        return respondWithObject('Successfully updated category', $category);
    }

    /**
     * delete category
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category) : JsonResponse
    {
        try{
            $category->delete();
            return respond('Category is successfully deleted');
        }catch (\Exception $exception)
        {
            return respond('Error during deletion', 500);
        }
    }
}
