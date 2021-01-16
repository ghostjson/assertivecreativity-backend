<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Resources\StockWishlistResource;
use App\Models\StockWishlist;
use Illuminate\Http\JsonResponse;

class StockWishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ]);
    }


    /**
     * Return all products in the wishlist
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $products = StockWishlist::where('user_id', auth()->id())->get();


        return response()->json([
            'data' => StockWishlistResource::collection($products),
            'total_price' => $this->sumOfProducts($products)
        ]);
    }

    public function show(StockWishlist $wishlist)
    {
        return new StockWishlistResource($wishlist);
    }

    /**
     * Add a new product to wishlist
     * @param StoreWishlistRequest $request
     * @return JsonResponse
     */
    public function store(StoreWishlistRequest $request) : JsonResponse
    {
        $wishlist = StockWishlist::create($request->validated());
        return respondWithObject('Successfully added product to wishlist', $wishlist);
    }


    /**
     * Remove a product from wishlist
     * @param StockWishlist $wishlist
     * @return JsonResponse
     */
    public function destroy(StockWishlist $wishlist) : JsonResponse
    {
        try {
            $wishlist->delete();
            return respond('Successfully deleted');
        }catch (\Exception $exception)
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
        if(StockWishlist::clear()) {
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
