<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ThreadSendRequest;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ]);
    }


    /**
     * Send a thread
     * @param ThreadSendRequest $request
     * @return JsonResponse
     */
    public function send(ThreadSendRequest $request) : JsonResponse
    {
        return Thread::send($request->validated()) ?
            respond('Successfully send thread') :
            respond('Failed to send thread', 500);
    }
}
