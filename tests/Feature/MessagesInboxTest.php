<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessagesInboxTest extends TestCase
{
    use RefreshDatabase;

    public function test_inbox_only_shows_conversations_involving_the_authenticated_user(): void
    {
        $owner = User::factory()->create(['name' => 'Inbox Owner']);
        $partner = User::factory()->create(['name' => 'Conversation Partner']);
        $outsider = User::factory()->create(['name' => 'Unrelated Person']);

        Message::create([
            'sender_id' => $partner->id,
            'receiver_id' => $owner->id,
            'message' => 'A message for this inbox.',
            'read_status' => false,
        ]);
        Message::create([
            'sender_id' => $outsider->id,
            'receiver_id' => $partner->id,
            'message' => 'A private message between other people.',
            'read_status' => false,
        ]);

        $this->actingAs($owner)
            ->get(route('messages.inbox'))
            ->assertOk()
            ->assertSee('Conversation Partner')
            ->assertDontSee('Unrelated Person')
            ->assertDontSee('A private message between other people.');
    }

    public function test_selected_conversation_shows_a_preview_and_full_chat_link(): void
    {
        $owner = User::factory()->create(['name' => 'Inbox Owner']);
        $partner = User::factory()->create(['name' => 'Conversation Partner']);
        $outsider = User::factory()->create(['name' => 'Unrelated Person']);

        Message::create([
            'sender_id' => $partner->id,
            'receiver_id' => $owner->id,
            'message' => 'Can you tell me more about this item?',
            'read_status' => false,
        ]);
        Message::create([
            'sender_id' => $outsider->id,
            'receiver_id' => $partner->id,
            'message' => 'This must not appear in the selected preview.',
            'read_status' => false,
        ]);

        $this->actingAs($owner)
            ->get(route('messages.inbox', ['user' => $partner->id]))
            ->assertOk()
            ->assertSee('Select a conversation', false)
            ->assertSee('Can you tell me more about this item?')
            ->assertSee(route('messages.thread', ['user' => $partner->id]), false)
            ->assertDontSee('This must not appear in the selected preview.');
    }
}
