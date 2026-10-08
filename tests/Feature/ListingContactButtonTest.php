<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingContactButtonTest extends TestCase
{
    use RefreshDatabase;

    public function test_listing_contact_button_is_an_alpine_root_that_dispatches_to_the_modal(): void
    {
        $seller = User::factory()->create(['name' => 'Seller O\'Brien']);
        $category = Category::create(['name' => 'Home Decor', 'slug' => 'home-decor']);
        $listing = Listing::create([
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'title' => 'Apostrophe Maker\'s Candle',
            'slug' => 'apostrophe-makers-candle',
            'description' => 'A handcrafted candle made with locally sourced ingredients and careful attention.',
            'price' => 3200,
            'location' => 'Kandy',
            'image_path' => 'https://images.example.test/candle.jpg',
            'status' => 'active',
        ]);

        $this->get(route('listings.show', $listing->slug))
            ->assertOk()
            ->assertSee('Contact Seller')
            ->assertSee('x-data="{}"', false)
            ->assertSee('x-on:click="$dispatch(\'open-contact-modal\'', false)
            ->assertSee('x-on:open-contact-modal.window="open($event.detail)"', false)
            ->assertSee('Apostrophe Maker\'s Candle');
    }
}
