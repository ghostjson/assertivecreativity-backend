<?php

namespace App\Http\Controllers\CustomProduct;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VendorAuthMiddleware;
use App\Http\Requests\ProductImportRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ShowUpdatedProductRequest;
use App\Http\Resources\CustomProductResource;
use App\Http\Resources\ProductResource;
use App\Jobs\ProductImportJob;
use App\Models\CustomProduct;
use App\Models\Role;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Claims\Custom;

class CustomProductController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ])->only(['store']);

        $this->middleware([
            VendorAuthMiddleware::class
        ])->only(['store', 'destroy', 'update', 'indexVendor']);


    }

    public function index()
    {
        return CustomProductResource::collection(CustomProduct::all());
    }

    public function show(CustomProduct $product)
    {
        return new CustomProductResource($product);
    }


    /**
     * Return All products of a vendor.
     *
     * @return ResourceCollection
     */
    public function indexVendor(): ResourceCollection
    {
        if (auth()->user()->isAdmin()) {
            return $this->index();
        } else {
            return CustomProductResource::collection(
                CustomProduct::where('seller_id', auth()->id())
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
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['seller_id'] = auth()->id();

        $validated['image'] = fileUploader($validated['image']);

        $product = CustomProduct::create($validated);

        return respondWithObject('successfully created', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param CustomProduct $product
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, CustomProduct $product): JsonResponse
    {
        $validated = $request->validated();

        if (isset($validated['image'])) {
            $validated['image'] = fileUploader($validated['image']);
        }

        if ($this->isOwner($product)) {
            $product->update($validated);
            return respondWithObject('Successfully updated product', (object)$validated);
        } else {
            return respond('Unauthorized', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CustomProduct $product
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(CustomProduct $product): JsonResponse
    {
        try {
            if ($this->isOwner($product)) {
                $product->delete();
                return respond('Successfully deleted');
            } else {
                return respond('Unauthorized', 401);
            }
        } catch (Exception $exception) {
            return respond('Could not delete', 500);
        }

    }


    /**
     * Get all products of a specific name
     *
     * @param string $search
     * @return ResourceCollection
     */
    public function productSearch(string $search): ResourceCollection
    {
        $search_results = CustomProduct::search($search)->get();

        return CustomProductResource::collection(
            $search_results
        );
    }

    /**
     * Check if the authenticated user is the owner of the product
     *
     * @param CustomProduct $product
     * @return bool
     */
    private function isOwner(CustomProduct $product): bool
    {
        return ((auth()->id() === $product->seller_id) || (auth()->id() === Role::getAdminRoleID()));
    }


}
