<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\ThreadSendRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Order;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            Authenticate::class
        ]);

        $this->middleware([
            AdminAuthMiddleware::class
        ])->only(['send', 'get']);

    }


    /**
     * Send a thread to a specific person
     * @param ThreadSendRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function send(ThreadSendRequest $request, User $user) : JsonResponse
    {
        $thread = Thread::send($request->validated(), $user) ?? false;


        return  $thread ?
            respondWithObject('Successfully send thread', new ThreadResource($thread)) :
            respond('Failed to send thread', 500);
    }

    /**
     * Get threads of a specific user
     * @param Order $order
     * @return array
     */
    public function get(Order $order) : array
    {
        if(auth()->user()->isAdmin())
        {
            return Thread::getThreadsByOrderAdmin($order);
        }
    }

    /**
     * Send thread to admin
     * @param ThreadSendRequest $request
     * @return JsonResponse
     */
    public function sendToAdmin(ThreadSendRequest $request)
    {
        $thread = Thread::sendToAdmin($request->validated()) ?? false;

        return  $thread ?
            respondWithObject('Successfully send thread', new ThreadResource($thread)) :
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
