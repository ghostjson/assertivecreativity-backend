<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ]);
    }

    /**
     * Create a new order
     * @param OrderStoreRequest $order
     * @return JsonResponse
     */
    public function store(OrderStoreRequest $order) : JsonResponse
    {
        return Order::new($order->validated()) ?
            respond('Successfully placed order') :
            respond('Error placing order', 500);
    }
}
