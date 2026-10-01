<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Listing;
use App\Notifications\NewMessageNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /**
     * Show inbox: unique conversation threads for the authenticated user.
     * Route: GET /messages/inbox
     */
    public function inbox(): View
    {
        $userId = auth()->id();

        // Get distinct conversations (partner user ID) involving this user
        $conversations = Message::query()
            ->where(fn ($q) => $q->where('sender_id', $userId)->orWhere('receiver_id', $userId))
            ->with(['sender', 'receiver', 'listing'])
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function (Message $msg) use ($userId) {
                // Group key: partner user ID (the other person)
                return $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
            })
            ->map(fn ($thread) => $thread->first()) // Latest message per thread
            ->values();

        $unreadCount = Message::where('receiver_id', $userId)
            ->where('read_status', false)
            ->count();

        return view('messages.inbox', compact('conversations', 'unreadCount'));
    }

    /**
     * Show conversation thread with a specific user (optionally about a listing).
     * Route: GET /messages/{user}
     */
    public function thread(User $user, Request $request): View
    {
        $myId      = auth()->id();
        $partnerId = $user->id;
        $listingId = $request->query('listing_id');

        $query = Message::query()
            ->where(fn ($q) => $q
                ->where(fn ($q2) => $q2->where('sender_id', $myId)->where('receiver_id', $partnerId))
                ->orWhere(fn ($q2) => $q2->where('sender_id', $partnerId)->where('receiver_id', $myId))
            )
            ->with(['sender', 'listing'])
            ->orderBy('created_at');

        if ($listingId) {
            $query->where('listing_id', $listingId);
        }

        $messages = $query->get();

        // Mark all incoming messages in this thread as read
        Message::where('sender_id', $partnerId)
            ->where('receiver_id', $myId)
            ->where('read_status', false)
            ->update(['read_status' => true]);

        $listing = $listingId ? Listing::find($listingId) : null;

        return view('messages.thread', compact('messages', 'user', 'listing'));
    }

    /**
     * Send a new message.
     * Route: POST /messages
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'listing_id'  => ['nullable', 'exists:listings,id'],
            'message'     => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        // Prevent self-messaging
        if ((int) $validated['receiver_id'] === auth()->id()) {
            return back()->with('error', 'You cannot message yourself.');
        }

        $listingId = $validated['listing_id'] ?? null;

        $message = Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'listing_id'  => $listingId,
            'message'     => $validated['message'],
            'read_status' => false,
        ]);

        $recipient = User::findOrFail($validated['receiver_id']);
        $recipient->notify(new NewMessageNotification([
            'type'  => 'message',
            'title' => 'New message from ' . auth()->user()->name,
            'body'  => Str::limit($message->message, 120),
            'url'   => route('messages.thread', [
                'user'       => auth()->id(),
                'listing_id' => $listingId,
            ]),
            'icon'  => 'message',
        ]));

        return redirect()->route('messages.thread', [
            'user'       => $validated['receiver_id'],
            'listing_id' => $listingId,
        ])->with('success', 'Message sent.');
    }
}
