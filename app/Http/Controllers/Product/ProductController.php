<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VendorAuthMiddleware;
use App\Http\Requests\ProductImportRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\ProductImportJob;
use App\Models\Product;
use App\Models\Role;
use App\Modules\ProductImporter\ProductImporter;
use Carbon\Carbon;
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
     * @return array
     */
    public function index() : array
    {
        $products = [];
        $product_names = Product::select('Name')->distinct()->get();
        foreach ($product_names as $product_name){
            array_push($products, Product::where('Name', $product_name->Name)->first());
        }
        return $products;
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

    public function import(ProductImportRequest $request)
    {
        dispatch(new ProductImportJob())->delay(Carbon::now()->addSeconds(5));
        return respond('Started importing from sheet');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Product
     */
    public function show(Product $product) : \Illuminate\Support\Collection
    {
        return Product::where('Name', $product->Name)->get();
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
        $validated = $request->validated();

        if(isset($validated['image']))
        {
            $validated['image'] = fileUploader($validated['image']);
        }

        if($this->isOwner($product))
        {
            $product->update($validated);
            return respondWithObject('Successfully updated product', (object)$validated);
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
