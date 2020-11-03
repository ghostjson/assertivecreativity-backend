<?php

namespace App\Models;

use App\Http\Resources\ThreadResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @property int|mixed|string|null sender_id
 * @property mixed receiver_id
 * @property mixed order_id
 * @property mixed message_content
 * @method static where(string $string, $id)
 */
class Thread extends Model
{
    use HasFactory;


    /**
     * Create a new thread
     * @param array $data
     * @param User $user
     * @return Thread
     */
    public static function send(array $data, User $user): Thread
    {
        $order = Order::find($data['order_id']);

        if (!is_null($order))
            if (
                $order->buyer_id == auth()->id() ||
                $order->seller_id == auth()->id() ||
                Auth::user()->isAdmin()) {


                $thread = new Thread;

                $thread->sender_id = auth()->id();
                $thread->receiver_id = $user->id;
                $thread->order_id = $data['order_id'];
                $thread->message_content = $data['message_content'];

                try {
                    $thread->save();
                    return $thread;
                } catch (\Exception $exception) {
                    Log::error($exception);
                }
            }


        return false;

    }


    /**
     * Send thread to admin
     * @param array $data
     * @return Thread|false
     */
    public static function sendToAdmin(array $data)
    {
        $order = Order::find($data['order_id']);

        if (!is_null($order))
            if (
                $order->buyer_id == auth()->id() ||
                $order->seller_id == auth()->id() ||
                Auth::user()->isAdmin()) {


                $thread = new Thread;

                $thread->sender_id = auth()->id();
                $thread->receiver_id = 1;
                $thread->order_id = $data['order_id'];
                $thread->message_content = $data['message_content'];

                try {
                    $thread->save();
                    return $thread;
                } catch (\Exception $exception) {
                    Log::error($exception);
                }
            }


        return false;
    }

    /**
     * Get messages of the current user by order id
     * @param Order $order
     * @return Collection
     */
    public static function getThreadsByOrder(Order $order): Collection
    {
        return Thread::where('order_id', $order->id)
            ->where(function ($query) use ($order) {
                $query->where('sender_id', \auth()->id())
                    ->orWhere('receiver_id', \auth()->id());
            })->get();
    }

    /**
     * Get messages of the current user by order id and group by user and vendor
     * @param Order $order
     * @return array
     */
    public static function getThreadsByOrderAdmin(Order $order): array
    {
        $threads = Thread::where('order_id', $order->id)
            ->where(function ($query) use ($order) {
                $query->where('sender_id', \auth()->id())
                    ->orWhere('receiver_id', \auth()->id());
            })->get();


        $users = [];
        $vendors = [];

        foreach ($threads as $thread) {
            if ($thread->sender->role_id == Role::getUserRoleID() ||
                $thread->receiver->role_id == Role::getUserRoleID()) {

                array_push($users, new ThreadResource($thread));
            } else if ($thread->sender->role_id == Role::getUserRoleID() ||
                $thread->receiver->role_id == Role::getUserRoleID()) {
                array_push($vendors, new ThreadResource($thread));
            }
        }

        return [
            'vendors' => $vendors,
            'users' => $users
        ];


    }


    /**
     * Get sender object
     * @return BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    /**
     * Get receiver object
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }


    /**
     * Get order object
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    /**
     * Check if this thead is belong to this user
     * @param int $user_id
     * @return bool
     */
    public function isBelongsTo(int $user_id)
    {
        return $this->receiver_id == $user_id || $this->sender_id == $user_id;
    }
}
