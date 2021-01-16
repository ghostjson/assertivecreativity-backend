<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Resources\CustomWishlistResource;
use App\Models\CustomWishlist;
use Illuminate\Http\JsonResponse;

class CustomWishlistController extends Controller
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
        $products = CustomWishlist::where('user_id', auth()->id())->get();


        return response()->json([
            'data' => CustomWishlistResource::collection($products),
            'total_price' => $this->sumOfProducts($products)
        ]);
    }

    public function show(CustomWishlist $wishlist)
    {
        return new CustomWishlistResource($wishlist);
    }

    /**
     * Add a new product to wishlist
     * @param StoreWishlistRequest $request
     * @return JsonResponse
     */
    public function store(StoreWishlistRequest $request) : JsonResponse
    {
        $wishlist = CustomWishlist::create($request->validated());
        return respondWithObject('Successfully added product to wishlist', $wishlist);
    }


    /**
     * Remove a product from wishlist
     * @param CustomWishlist $wishlist
     * @return JsonResponse
     */
    public function destroy(CustomWishlist $wishlist) : JsonResponse
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
        if(CustomWishlist::clear()) {
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
