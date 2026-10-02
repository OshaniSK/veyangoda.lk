<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Home Decor', 'slug' => 'home-decor']);
        
        $listing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Handmade Teak Candle',
            'slug' => 'handmade-teak-candle',
            'description' => 'A beautiful scented soy wax candle.',
            'price' => 1500,
            'location' => 'Kandy',
            'image_path' => 'listings/sample.jpg',
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Handmade Teak Candle');
        $response->assertSee($listing->image_url, false);
    }

    public function test_can_search_listings_by_keyword(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Homemade Food', 'slug' => 'homemade-food']);

        Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Organic Mango Chutney',
            'slug' => 'organic-mango-chutney',
            'description' => 'Delicious homemade recipe with natural spices.',
            'price' => 850,
            'location' => 'Matale',
            'status' => 'active',
        ]);

        Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Brass Oil Lamp',
            'slug' => 'brass-oil-lamp',
            'description' => 'Handcrafted traditional lamp.',
            'price' => 4500,
            'location' => 'Colombo',
            'status' => 'active',
        ]);

        $response = $this->get('/?search=Chutney');
        $response->assertStatus(200);
        $response->assertSee('Organic Mango Chutney');
        $response->assertDontSee('Brass Oil Lamp');
    }

    public function test_can_filter_listings_by_price_and_location(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Textiles', 'slug' => 'textiles']);

        Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Batik Pillow Cover',
            'slug' => 'batik-pillow-cover',
            'description' => 'Handmade cotton batik pillow.',
            'price' => 1200,
            'location' => 'Kandy',
            'status' => 'active',
        ]);

        Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Silk Handloom Saree',
            'slug' => 'silk-handloom-saree',
            'description' => 'Pure handloom silk saree.',
            'price' => 15000,
            'location' => 'Colombo',
            'status' => 'active',
        ]);

        $response = $this->get('/?max_price=2000&location=Kandy');
        $response->assertStatus(200);
        $response->assertSee('Batik Pillow Cover');
        $response->assertDontSee('Silk Handloom Saree');
    }

    public function test_guest_is_redirected_when_trying_to_post_ad(): void
    {
        $response = $this->get('/listings/create');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_post_ad_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/listings/create');

        $response->assertStatus(200);
        $response->assertSee('Post an Advertisement');
        $response->assertSee('Veyangoda.lk');
        $response->assertSee('Back to Home');
        $response->assertDontSee('POST YOUR AD');
    }

    public function test_authenticated_user_can_store_listing_with_multiple_images(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::create(['name' => 'Pottery', 'slug' => 'pottery']);

        $images = [
            UploadedFile::fake()->create('clay_pot.jpg', 1500, 'image/jpeg'),
            UploadedFile::fake()->create('clay_pot_side.png', 1200, 'image/png'),
        ];

        $response = $this->actingAs($user)->post('/listings', [
            'title' => 'Handcrafted Terracotta Pot',
            'category_id' => $category->id,
            'price' => 1800,
            'location' => 'Kandy',
            'description' => 'Earthenware clay pot fired in wood kilns with traditional motifs.',
            'images' => $images,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('listings', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Handcrafted Terracotta Pot',
            'price' => 1800,
            'location' => 'Kandy',
            'status' => 'active',
        ]);

        $listing = Listing::firstWhere('title', 'Handcrafted Terracotta Pot');
        $this->assertNotNull($listing->image_path);
        Storage::disk('public')->assertExists($listing->image_path);
        $this->assertCount(2, $listing->images);
        Storage::disk('public')->assertExists($listing->images[1]->image_path);
    }

    public function test_store_listing_fails_validation_if_any_image_exceeds_2mb(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::create(['name' => 'Pottery', 'slug' => 'pottery']);

        $largeImage = UploadedFile::fake()->create('large_photo.jpg', 3000, 'image/jpeg'); // 3MB (exceeds 2048KB limit)

        $response = $this->actingAs($user)->post('/listings', [
            'title' => 'Handcrafted Terracotta Pot',
            'category_id' => $category->id,
            'price' => 1800,
            'location' => 'Kandy',
            'description' => 'Earthenware clay pot fired in wood kilns with traditional motifs.',
            'images' => [UploadedFile::fake()->create('valid.jpg', 100, 'image/jpeg'), $largeImage],
        ]);

        $response->assertSessionHasErrors('images.1');
    }
}
