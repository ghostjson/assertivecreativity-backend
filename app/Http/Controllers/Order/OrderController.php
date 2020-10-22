<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ]);

        $this->middleware([

        ]);
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
     * Create a new order
     * @param OrderStoreRequest $order
     * @return JsonResponse
     */
    public function store(OrderStoreRequest $order) : JsonResponse
    {
        $order = Order::new($order->validated()) ?? false;

        return  $order ?
            respondWithObject('Successfully placed order', $order) :
            respond('Error placing order', 500);
    }

    /**
     * Return specific order
     * @param Order $order
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
