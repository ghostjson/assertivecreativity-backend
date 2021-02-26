<?php

namespace App\Http\Controllers\StockProduct;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VendorAuthMiddleware;
use App\Http\Requests\ProductsByCategoryRequest;
use App\Http\Requests\ShowUpdatedProductRequest;
use App\Http\Requests\StockProductSearch;
use App\Jobs\ProductImportJob;
use App\Models\StockProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StockProductController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            VendorAuthMiddleware::class
        ])->only(['import', 'deleteProduct']);
    }

    /**
     * Return All products .
     * @return array
     */
    public function index(): array
    {
        $products = [];
        $product_objects = StockProduct::select('product_key')->distinct()->get();
        foreach ($product_objects as $product_object) {
            array_push($products, StockProduct::where('product_key', $product_object->product_key)->first());
        }
        return $products;
    }

    /**
     * Display the specified resource.
     *
     * @param int $product_key
     * @return array
     */
    public function show(int $product_key)
    {
        $product = StockProduct::where('product_key', $product_key)->first();

        $variants = StockProduct::where('product_key', $product_key);
        $colors = $variants->select('colors')->distinct()->get();
        $variant_ids = $variants->select('variant_id')->distinct()->get();


        return [
            'product' => $product->toArray(),
            'attributes' => [
                'colors' => $this->getValues($colors->toArray()),
                'variant_ids' => $this->getValues($variant_ids->toArray())
            ],
        ];

    }

    /**
     * Import stock products from excel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        Storage::putFileAs('public', $request->file('sheet'), 'products.xls');

        dispatch(new ProductImportJob())->delay(Carbon::now()->addSeconds(5));
        return respond('Started importing from sheet');
    }


    /**
     * Give updated variant using given attributes
     * @param ShowUpdatedProductRequest $request
     * @param int $product_key
     * @return mixed
     */
    public function showUpdatedProduct(ShowUpdatedProductRequest $request, int $product_key)
    {
        $conditions = $request->validated();
        $conditions = $conditions + ['product_key' => $product_key];
        return StockProduct::where($conditions)->get();
    }

    /**
     * Delete stock product
     * @param int $product_key
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProduct(int $product_key)
    {
        $products = StockProduct::where('product_key', $product_key);
        try {
            $products->delete();
            return respond("Successfully deleted");
        } catch (\Exception $e) {
            Log::error($e);
            return respond("Error during deletion");
        }
    }



    /**
     * Return all categories
     * @return array
     */
    public function categories()
    {
        return array_values(
            array_unique(
                StockProduct::all()
                    ->pluck('category')
                    ->toArray()
            )
        );

    }

    /**
     * Return products under given category name
     * @param ProductsByCategoryRequest $request
     * @return array
     */
    public function getProductsByCategoryName(ProductsByCategoryRequest $request)
    {
        $products = [];
        $categories = $request->input('categories');

        foreach ($categories as $category){
            array_push($products, StockProduct::where('category', $category)
                ->get()
                ->unique('product_key')
                ->values());
        }


        return $products;
    }

    /**
     * Search a particular product
     * @param StockProductSearch $search
     * @return array
     */
    public function search(StockProductSearch $search)
    {
        $products = [];
        $product_names = StockProduct::where('name', 'LIKE', '%'. $search->input('query') .'%')
            ->select('product_key')->distinct()
            ->get();

        foreach ($product_names as $product_name) {
            array_push($products, StockProduct::where('name', $product_name->name)->first());
        }
        return $products;
    }

    /**
     * Get product by variant id
     * @param string $variant_id
     * @return mixed
     */
    public function getVariant(string $variant_id)
    {
        return StockProduct::where('variant_id', $variant_id)
            ->first();
    }

    /**
     * Return values of associated array
     * @param $array
     * @return array
     */
    private function getValues($array)
    {
        $values = [];
        foreach ($array as $value)
        {
            array_push($values, array_values($value)[0]);
        }

        return $values;
    }
}
