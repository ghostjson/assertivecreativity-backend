<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VendorAuthMiddleware;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
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
        ])->only(['store', 'destroy']);
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
