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
            'data' => WishlistResource::collection($products),
            'total_price' => $this->sumOfProducts($products)
        ]);
    }

    public function show(Wishlist $wishlist)
    {
        return new WishlistResource($wishlist);
    }

    /**
     * Add a new product to wishlist
     * @param StoreWishlistRequest $request
     * @return JsonResponse
     */
    public function store(StoreWishlistRequest $request) : JsonResponse
    {
        $wishlist = Wishlist::create($request->validated());
        return respondWithObject('Successfully added product to wishlist', $wishlist);
    }


    /**
     * Remove a product from wishlist
     * @param Wishlist $wishlist
     * @return JsonResponse
     */
    public function destroy(Wishlist $wishlist) : JsonResponse
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
