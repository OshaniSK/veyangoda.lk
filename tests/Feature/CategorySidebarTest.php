<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorySidebarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\LocationSeeder::class);
        $this->seed(\Database\Seeders\CategoryAndSubCategorySeeder::class);
    }

    public function test_homepage_renders_all_10_categories_in_sidebar(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Browse items', false);
        $response->assertSee('by category', false);
        $response->assertSee('Vehicles');
        $response->assertSee('Electronics');
        $response->assertSee('Property');
        $response->assertSee('Home &amp; Garden', false);
        $response->assertSee('Fashion, Health &amp; Beauty', false);
        $response->assertSee('Hobby, Sport &amp; Kids', false);
        $response->assertSee('Business &amp; Industry', false);
        $response->assertSee('Services');
        $response->assertSee('Education');
        $response->assertSee('Animals');
    }

    public function test_sidebar_shows_only_active_listing_counts_per_category_and_subcategory(): void
    {
        $user = User::factory()->create();
        $vehicles = Category::where('slug', 'vehicles')->firstOrFail();
        $electronics = Category::where('slug', 'electronics')->firstOrFail();
        $cars = SubCategory::where('slug', 'cars')->where('category_id', $vehicles->id)->firstOrFail();
        $bikes = SubCategory::where('slug', 'motorbikes-scooters')->where('category_id', $vehicles->id)->firstOrFail();
        $phones = SubCategory::where('slug', 'mobile-phones-accessories')
            ->where('category_id', $electronics->id)
            ->firstOrFail();

        $createListing = function (Category $category, SubCategory $subCategory, string $slug, string $status = 'active') use ($user): void {
            Listing::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'sub_category_id' => $subCategory->id,
                'title' => $slug,
                'slug' => $slug,
                'description' => 'Test listing',
                'price' => 1000,
                'location' => 'Veyangoda',
                'status' => $status,
            ]);
        };

        $createListing($vehicles, $cars, 'active-car');
        $createListing($vehicles, $cars, 'sold-car', 'sold');
        $createListing($vehicles, $bikes, 'active-bike');
        $createListing($electronics, $phones, 'active-phone');

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Cars');
        $response->assertSee('2 ads');
        $response->assertSee('(1)', false);
        $response->assertSee('Motorbikes &amp; Scooters', false);
        $response->assertSee('Three Wheelers');
        $response->assertSee('(0)', false);
        $response->assertSee('Mobile Phones &amp; Accessories', false);
        $response->assertSee('Computers &amp; Laptops', false);
        $response->assertSee('Land &amp; Plots', false);
        $response->assertSee('Houses For Sale');
        $response->assertSee('Dogs &amp; Puppies', false);
        $response->assertDontSee('1,553+ ads');
        $response->assertDontSee('(573)', false);
    }

    public function test_sidebar_includes_more_details_keyword_search_feature(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('More details');
        $response->assertSee('Filter ads by specific features, brand, model, or keywords.');
        $response->assertSee('placeholder="e.g. Toyota, automatic, pet..."', false);
        $response->assertSee('Apply Keyword');
    }

    public function test_filtering_by_category_and_subcategory_via_ajax(): void
    {
        $user = User::factory()->create();
        $vehicles = Category::where('slug', 'vehicles')->firstOrFail();
        $cars = SubCategory::where('slug', 'cars')->where('category_id', $vehicles->id)->firstOrFail();
        $bikes = SubCategory::where('slug', 'motorbikes-scooters')->where('category_id', $vehicles->id)->firstOrFail();

        $carListing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $vehicles->id,
            'sub_category_id' => $cars->id,
            'title' => 'Toyota Prius Hybrid 2018',
            'slug' => 'toyota-prius-hybrid-2018',
            'description' => 'Mint condition hybrid car in Veyangoda',
            'price' => 7500000,
            'location' => 'Veyangoda',
            'status' => 'active',
        ]);

        $bikeListing = Listing::create([
            'user_id' => $user->id,
            'category_id' => $vehicles->id,
            'sub_category_id' => $bikes->id,
            'title' => 'Yamaha FZ Version 3',
            'slug' => 'yamaha-fz-version-3',
            'description' => 'Single owner motorbike in Gampaha',
            'price' => 850000,
            'location' => 'Gampaha',
            'status' => 'active',
        ]);

        // Filter by subcategory = cars
        $response = $this->get(route('home', [
            'category' => 'vehicles',
            'sub_category' => 'cars',
        ]), ['X-Requested-With' => 'XMLHttpRequest', 'Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonStructure(['html', 'total']);
        $html = $response->json('html');
        $this->assertStringContainsString('Toyota Prius Hybrid 2018', $html);
        $this->assertStringNotContainsString('Yamaha FZ Version 3', $html);
    }

    public function test_keyword_search_filters_listings(): void
    {
        $user = User::factory()->create();
        $electronics = Category::where('slug', 'electronics')->firstOrFail();

        Listing::create([
            'user_id' => $user->id,
            'category_id' => $electronics->id,
            'title' => 'Apple MacBook Pro M2',
            'slug' => 'apple-macbook-pro-m2',
            'description' => '16GB RAM 512GB SSD Space Gray',
            'price' => 450000,
            'location' => 'Colombo',
            'status' => 'active',
        ]);

        Listing::create([
            'user_id' => $user->id,
            'category_id' => $electronics->id,
            'title' => 'Samsung 55 inch QLED TV',
            'slug' => 'samsung-55-inch-qled-tv',
            'description' => '4K Smart TV with Dolby Atmos',
            'price' => 220000,
            'location' => 'Kandy',
            'status' => 'active',
        ]);

        $response = $this->get(route('home', [
            'search' => 'MacBook',
        ]), ['X-Requested-With' => 'XMLHttpRequest', 'Accept' => 'application/json']);

        $response->assertStatus(200);
        $html = $response->json('html');
        $this->assertStringContainsString('Apple MacBook Pro M2', $html);
        $this->assertStringNotContainsString('Samsung 55 inch QLED TV', $html);
    }
}
