<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VendorAuthMiddleware;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ])->only(['store']);

        $this->middleware([
            VendorAuthMiddleware::class
        ])->only(['store', 'destroy', 'update']);

        $this->middleware([
           AdminAuthMiddleware::class
        ])->only(['storeCategory', 'updateCategory', 'storeTag', 'updateTag']);
    }

    /**
     * Return All products .
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return ProductResource::collection(Product::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request) : JsonResponse
    {
        $validated = $request->validated();

        $validated['seller_id'] = auth()->id();

        Product::create($validated);

        return respond('successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product) : ProductResource
    {
        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, Product $product) : JsonResponse
    {
        if($this->isOwner($product))
        {
            $product->update($request->validated());
            return respond('Successfully updated product');
        }
        else
        {
            return respond('Unauthorized', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Product $product) : JsonResponse
    {
        try{
            if($this->isOwner($product))
            {
                $product->delete();
                return respond('Successfully deleted');
            }
            else
            {
                return respond('Unauthorized', 401);
            }
        }
        catch(\Exception $exception)
        {
            return respond('Could not delete', 500);
        }

    }


    /**
     * Get all Categories
     *
     * @return ResourceCollection
     */
    public function getAllCategory() : ResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }


    /**
     * Get all products of a specific category
     *
     * @param Category $category
     * @return ResourceCollection
     */
    public function getByCategoryID(Category $category) : ResourceCollection
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
    public function getTagsAssociatedWithCategory(Category $category) : ResourceCollection
    {
        return TagResource::collection($category->tags());
    }

    /**
     * Create a new category
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function storeCategory(StoreCategoryRequest $request) : JsonResponse
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
    public function updateCategory(StoreCategoryRequest $request, Category $category) : JsonResponse
    {
        $category->update($request->validated());
        return respond('Successfully updated category');
    }

    /**
     * Store a new tag
     *
     * @param StoreTagRequest $request
     * @return JsonResponse
     */
    public function storeTag(StoreTagRequest $request) : JsonResponse
    {
        Tag::create($request->validated());

        return respond('Successfully created tag');
    }

    /**
     * Store a new tag
     *
     * @param StoreTagRequest $request
     * @param Tag $tag
     * @return JsonResponse
     */
    public function updateTag(StoreTagRequest $request, Tag $tag) : JsonResponse
    {
        $tag->update($request->validated());

        return respond('Successfully updated tag');
    }

    /**
     * Get all products of a specific category
     *
     * @param Tag $tag
     * @return ResourceCollection
     */
    public function getByTagID(Tag $tag) : ResourceCollection
    {
        return ProductResource::collection(
            $tag->products
        );
    }

    /**
     * Get all products of a specific tag name
     *
     * @param string $name
     * @return ResourceCollection
     */
    public function getByTagName(string $name) : ResourceCollection
    {
        return ProductResource::collection(
            Tag::where('name', $name)->first()->products
        );
    }

    /**
     * Get all products of a specific tag name
     *
     * @param string $search
     * @return ResourceCollection
     */
    public function productSearch(string $search) : ResourceCollection
    {
        $search_results = Product::where('name', 'LIKE', '%'.$search.'%')->limit(1)->get();

        return ProductResource::collection(
            $search_results
        );
    }

    /**
     * Check if the authenticated user is the owner of the product
     *
     * @param Product $product
     * @return bool
     */
    private function isOwner(Product $product) : bool
    {
        return ((auth()->id() === $product->seller_id) || (auth()->id() === Role::getAdminRoleID()));
    }
}
