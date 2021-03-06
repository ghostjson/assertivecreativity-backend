<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VendorAuthMiddleware;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Role;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ]);

        $this->middleware([
            VendorAuthMiddleware::class
        ])->only(['indexVendor']);

        $this->middleware([
            AdminAuthMiddleware::class
        ])->only(['indexAdmin']);
    }


    /**
     * Return all orders of a current user
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return OrderResource::collection(
            Order::where('buyer_id', auth()->id())
                ->get()
        );
    }

    /**
     * Return all orders respect to vendor
     * @return ResourceCollection
     */
    public function indexVendor() : ResourceCollection
    {
        return OrderResource::collection(
            Order::where('seller_id', auth()->id())
                ->get()
        );
    }

    /**
     * Return all orders of the website
     * @return ResourceCollection
     */
    public function indexAdmin() : ResourceCollection
    {

        return OrderResource::collection(
            Order::orderBy('created_at', 'desc')->get()
        );
    }

    /**
     * Create a new order custom product
     * @param OrderStoreRequest $order
     * @return JsonResponse
     */
    public function storeCustom(OrderStoreRequest $order) : JsonResponse
    {
        $order = Order::new($order->validated(), 'custom') ?? false;

        return  $order ?
            respondWithObject('Successfully placed order', $order) :
            respond('Error placing order', 500);
    }

    /**
     * Create a new order for stock product
     * @param OrderStoreRequest $order
     * @return JsonResponse
     */
    public function storeStock(OrderStoreRequest $order) : JsonResponse
    {
        $order = Order::new($order->validated(), 'stock') ?? false;

        return  $order ?
            respondWithObject('Successfully placed order', $order) :
            respond('Error placing order', 500);
    }


    /**
     * Return a specific product
     * @param Order $order
     * @return OrderResource|JsonResponse
     */
    public function show(Order $order)
    {
        if($this->isOwner($order)){
            return new OrderResource($order);
        }
        else{
            return respond('Unauthorized', 401);
        }
    }

    /**
     *
     * @param Order $order
     * @return bool
     */
    private function isOwner(Order $order) : bool
    {
        return (auth()->id() == $order->buyer_id) || (auth()->id() == $order->seller_id) || Role::getAdminRoleID();
    }

}
