<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrowseListingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_slug_filters_browse_results_and_renders_the_category_page(): void
    {
        $seller = User::factory()->create();
        $handicrafts = Category::create(['name' => 'Handicrafts & Art', 'slug' => 'handicrafts-art']);
        $food = Category::create(['name' => 'Homemade Food', 'slug' => 'homemade-food']);

        $matchingListing = $this->createListing($seller, $handicrafts, 'Handmade Carved Bowl', 'Veyangoda', 1800);
        $otherListing = $this->createListing($seller, $food, 'Homemade Mango Chutney', 'Gampaha', 900);

        $this->get(route('listings.index', ['category' => 'handicrafts-art']))
            ->assertOk()
            ->assertSee('Handicrafts & Art')
            ->assertSee($matchingListing->title)
            ->assertDontSee($otherListing->title)
                ->assertSee('name="category" value="handicrafts-art"', false);
    }

    public function test_search_and_location_filters_apply_with_category_and_price_sort(): void
    {
        $seller = User::factory()->create();
        $category = Category::create(['name' => 'Home Decor', 'slug' => 'home-decor']);
        $moreExpensive = $this->createListing($seller, $category, 'Candle Holder Oak', 'Veyangoda', 2000);
        $lessExpensive = $this->createListing($seller, $category, 'Candle Holder Teak', 'Veyangoda', 1000);
        $wrongLocation = $this->createListing($seller, $category, 'Candle Holder Pine', 'Kandy', 500);

        $response = $this->get(route('listings.index', [
            'category' => 'home-decor',
            'search' => 'Candle Holder',
            'location' => 'Veyangoda',
            'sort' => 'price_asc',
        ]));

        $response->assertOk()
            ->assertSee($lessExpensive->title)
            ->assertSee($moreExpensive->title)
            ->assertDontSee($wrongLocation->title);

        $this->assertLessThan(
            strpos($response->getContent(), $moreExpensive->title),
            strpos($response->getContent(), $lessExpensive->title)
        );
    }

    public function test_home_category_card_links_to_slug_filtered_browse_route(): void
    {
        $seller = User::factory()->create();
        $category = Category::create(['name' => 'Handicrafts & Art', 'slug' => 'handicrafts-art']);
        $this->createListing($seller, $category, 'Handmade Art Piece', 'Veyangoda', 1000);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('listings.index', ['category' => 'handicrafts-art']), false);
    }

    private function createListing(User $seller, Category $category, string $title, string $location, int $price): Listing
    {
        return Listing::create([
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'title' => $title,
            'slug' => str($title)->slug() . '-' . fake()->unique()->numberBetween(100, 999),
            'description' => 'A carefully made local product, crafted with quality materials for everyday use.',
            'price' => $price,
            'location' => $location,
            'image_path' => 'https://images.example.test/listings/' . str($title)->slug() . '.jpg',
            'status' => 'active',
        ]);
    }
}
