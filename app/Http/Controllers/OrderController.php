<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ])->only(['store']);
    }

    public function store(OrderStoreRequest $order)
    {
        return Order::new($order->validated()) ?
            respond('Successfully placed order') :
            respond('Error placing order');
    }
}
