<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            AdminAuthMiddleware::class
        );
    }

    public function index()
    {
        return MessageResource::collection(Message::all());
    }

    public function show(Message $message)
    {
        return new MessageResource($message);
    }

    public function store(CreateMessageRequest $request)
    {
        try {
            $message = Message::create($request->validated());
            return respondWithObject('Successfully created message', $message);
        }catch (\Exception $exception){
            Log::error($exception);
            return respond('Error creating message', 500);
        }
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        try {
            $message->update($request->validated());
            return respondWithObject('Successfully update message', $message);
        }catch (\Exception $exception){
            Log::error($exception);
            return respond('Error update message', 500);
        }
    }

    public function delete(Message $message)
    {
        try {
            $message->delete();
            return respondWithObject('Successfully deleted message', $message);
        }catch (\Exception $exception){
            Log::error($exception);
            return respond('Error delete message', 500);
        }
    }
}
