<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sending_a_message_creates_a_notification_for_the_recipient(): void
    {
        $sender = User::factory()->create(['name' => 'Buyer']);
        $seller = User::factory()->create(['name' => 'Seller']);

        $this->actingAs($sender)
            ->post('/messages', [
                'receiver_id' => $seller->id,
                'message' => 'Is this handmade item available?',
            ])
            ->assertRedirect(route('messages.thread', ['user' => $seller->id]));

        $notification = $seller->notifications()->first();

        $this->assertNotNull($notification);
        $this->assertSame('message', $notification->data['type']);
        $this->assertSame('New message from Buyer', $notification->data['title']);
        $this->assertSame('Is this handmade item available?', $notification->data['body']);
        $this->assertSame(route('messages.thread', ['user' => $sender->id]), $notification->data['url']);
        $this->assertSame('message', $notification->data['icon']);

        $this->actingAs($seller)
            ->getJson('/api/notifications')
            ->assertOk()
            ->assertJsonPath('count', 1)
            ->assertJsonPath('notifications.0.data.title', 'New message from Buyer');
    }
}