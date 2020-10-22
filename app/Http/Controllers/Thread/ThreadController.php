<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\ThreadSendRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Order;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

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


    /**
     * Get threads of the current user by order id
     * @param Order $order
     * @return ResourceCollection
     */
    public function getThreadsByOrder(Order $order) : ResourceCollection
    {

        return ThreadResource::collection(
            Thread::getThreadsByOrder($order)
        );
    }

    /**
     * Get threads by current user id ( sorted by date )
     * @return ResourceCollection
     */
    public function getThreadsByCurrentUser() : ResourceCollection
    {
        return ThreadResource::collection(
            Thread::where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())
                ->orderBy('created_at')
                ->get()
        );
    }

    /**
     * Get thread by id
     * @param Thread $thread
     * @return ThreadResource|JsonResponse
     */
    public function getThreadById(Thread $thread)
    {
        if($thread->isBelongsTo(auth()->id()))
        {
            return new ThreadResource($thread);
        }else{
            return respond('Not found', 404);
        }
    }
}
