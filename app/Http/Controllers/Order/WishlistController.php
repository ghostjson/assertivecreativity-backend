<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WishlistResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Ramsey\Collection\Collection;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware([
           Authenticate::class
        ]);
    }


    /**
     * Return all products in the wishlist
     * @return ResourceCollection
     */
    public function index() : JsonResponse
    {
        $products = Wishlist::where('user_id', auth()->id())->get();


        return response()->json([
            'data' => $products,
            'total_price' => $this->sumOfProducts($products)
        ]);
    }

    /**
     * Add a new product to wishlist
     * @param StoreWishlistRequest $request
     * @return JsonResponse
     */
    public function store(StoreWishlistRequest $request) : JsonResponse
    {
        Wishlist::create($request->validated());
        return respond('Successfully added product to wishlist');
    }

    /**
     * Remove a product from wishlist
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product) : JsonResponse
    {
        if(Wishlist::removeProduct($product)) {
            return respond('Successfully deleted');
        }else
        {
            return respond('Error occur during deletion', 500);
        }
    }

    /**
     * remove all products from wishlist
     * @return JsonResponse
     */
    public function clear() : JsonResponse
    {
        if(Wishlist::clear()) {
            return respond('Successfully cleared wishlist');
        }else
        {
            return respond('Error occur during deletion', 500);
        }
    }

    private function sumOfProducts(\Illuminate\Database\Eloquent\Collection $products) : int
    {

        $total = 0;

        foreach ($products as $product)
        {
            $total += (int) $product->product->base_price * (int) $product->quantity;
        }

        return $total;
    }
}
