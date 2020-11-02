<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
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
use Exception;
use Illuminate\Http\JsonResponse;
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
     * Return All products of a vendor.
     *
     * @return ResourceCollection
     */
    public function indexVendor() : ResourceCollection
    {
        if(auth()->user()->isAdmin())
        {
            return $this->index();
        }else{
            return ProductResource::collection(
                Product::where('seller_id', auth()->id())
                    ->get()
                );
        }
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

        $validated['image'] = fileUploader($validated['image']);

        $product = Product::create($validated);

        return respondWithObject('successfully created', $product);
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
            return respondWithObject('Successfully updated product', $product);
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
     * @throws Exception
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
        catch(Exception $exception)
        {
            return respond('Could not delete', 500);
        }

    }


    /**
     * Get all products of a specific tag name
     *
     * @param string $search
     * @return ResourceCollection
     */
    public function productSearch(string $search) : ResourceCollection
    {
        $search_results = Product::search($search)->get();

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
