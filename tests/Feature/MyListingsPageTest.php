<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListingsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_my_listings_page_uses_branded_empty_state_without_nav_post_ad_cta(): void
    {
        $user = User::factory()->create(['name' => 'Local Seller']);

        $this->actingAs($user)
            ->get(route('my-listings.index'))
            ->assertOk()
            ->assertSee('Veyangoda.lk')
            ->assertSee('Manage your active ads and track sales performance.')
            ->assertSee("You haven't posted any ads yet", false)
            ->assertSee('Post Your First Ad')
            ->assertSee('Go Home')
            ->assertSee('Buy and sell everything from homemade food to real estate safely in Sri Lanka.')
            ->assertDontSee('POST YOUR AD')
            ->assertDontSee('Post Free Ad');
    }

    public function test_my_listings_page_shows_statistics_and_existing_listing_actions(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Home Decor', 'slug' => 'home-decor']);

        Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Handmade Ceramic Vase',
            'slug' => 'handmade-ceramic-vase',
            'description' => 'A handcrafted ceramic vase fired and glazed by a local artisan.',
            'price' => 3200,
            'location' => 'Veyangoda',
            'status' => 'active',
            'views_count' => 7,
        ]);

        $this->actingAs($user)
            ->get(route('my-listings.index'))
            ->assertOk()
            ->assertSee('Total Ads')
            ->assertSee('Active')
            ->assertSee('Sold')
            ->assertSee('Handmade Ceramic Vase')
            ->assertSee('Mark Sold')
            ->assertSee('Edit')
            ->assertSee('Delete')
            ->assertSee('7 views');
    }
}
