<?php

namespace App\Http\Controllers\StockProduct;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowUpdatedProductRequest;
use App\Jobs\ProductImportJob;
use App\Models\CustomProduct;
use App\Models\StockProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StockProductController extends Controller
{

    /**
     * Return All products .
     * @return array
     */
    public function index(): array
    {
        $products = [];
        $product_names = StockProduct::select('Name')->distinct()->get();
        foreach ($product_names as $product_name) {
            array_push($products, StockProduct::where('Name', $product_name->Name)->first());
        }
        return $products;
    }

    /**
     * Display the specified resource.
     *
     * @param StockProduct $product
     * @return array
     */
    public function show(StockProduct $product)
    {
        $variants = StockProduct::where('Name', $product->Name);
        $colors = $variants->select('Colors')->distinct()->get();

        return [
            'product' => $product->toArray(),
            'attributes' => [
                'Colors' => $this->getValues($colors->toArray())
            ],
        ];

    }

    public function import(Request $request)
    {
        Storage::putFileAs('public', $request->file('sheet'), 'products.xls');

        dispatch(new ProductImportJob())->delay(Carbon::now()->addSeconds(5));
        return respond('Started importing from sheet');
    }



    public function showUpdatedProduct(ShowUpdatedProductRequest $request, StockProduct $product)
    {
        $conditions = $request->validated();
        $conditions = $conditions + ['Name' => $product->Name];
        return StockProduct::where($conditions)->get();
    }


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
