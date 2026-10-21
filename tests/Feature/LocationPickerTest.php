<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\LocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class LocationPickerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LocationSeeder::class);
    }

    public function test_locations_table_is_seeded_with_25_districts_and_their_areas(): void
    {
        $this->assertEquals(25, Location::districts()->count());
        $this->assertGreaterThan(200, Location::query()->areas()->count());

        $gampaha = Location::districts()->where('name', 'Gampaha')->with('areas')->first();
        $this->assertNotNull($gampaha);
        $this->assertTrue($gampaha->areas->contains('name', 'Veyangoda'));
        $this->assertTrue($gampaha->areas->contains('name', 'Negombo'));

        $colombo = Location::districts()->where('name', 'Colombo')->with('areas')->first();
        $this->assertNotNull($colombo);
        $this->assertTrue($colombo->areas->contains('name', 'Malabe'));
        $this->assertTrue($colombo->areas->contains('name', 'Moratuwa'));
    }

    public function test_homepage_and_listings_index_render_cascading_location_picker(): void
    {
        $responseHome = $this->get('/');
        $responseHome->assertOk();
        $responseHome->assertSee('masterDetailLocationPicker');
        $responseHome->assertSee('Districts (A-Z)');
        $responseHome->assertSee('All of Sri Lanka');
        // Verify key districts are in the HTML
        $responseHome->assertSee('Ampara');
        $responseHome->assertSee('Colombo');
        $responseHome->assertSee('Gampaha');
        $responseHome->assertSee('Kandy');
        $responseHome->assertSee('Vavuniya');
        // Verify local areas are in the HTML
        $responseHome->assertSee('Veyangoda');
        $responseHome->assertSee('Negombo');
        $responseHome->assertSee('Kalmunai');
        $responseHome->assertSee('Dehiwala');
        $responseHome->assertSee('All of Gampaha');

        $responseListings = $this->get(route('listings.index'));
        $responseListings->assertOk();
        $responseListings->assertSee('masterDetailLocationPicker');
        $responseListings->assertSee('browse-location');
        $responseListings->assertSee('Veyangoda');
        $responseListings->assertSee('Colombo');
    }

    public function test_filter_by_district_matches_listings_in_district_or_any_child_area(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Food & Agriculture',
            'slug' => 'food-agriculture',
        ]);

        $adInVeyangoda = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Fresh Honey Veyangoda',
            'slug' => Str::slug('Fresh Honey Veyangoda ' . uniqid()),
            'description' => 'Pure honey straight from local farms.',
            'price' => 1500,
            'location' => 'Veyangoda',
            'phone_number' => '0771234567',
            'status' => 'active',
        ]);

        $adInGampahaCity = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Handmade Basket Gampaha',
            'slug' => Str::slug('Handmade Basket Gampaha ' . uniqid()),
            'description' => 'Woven craft basket made locally in Gampaha.',
            'price' => 2000,
            'location' => 'Gampaha',
            'phone_number' => '0771234567',
            'status' => 'active',
        ]);

        $adInKandy = Listing::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Wood Carving Kandy',
            'slug' => Str::slug('Wood Carving Kandy ' . uniqid()),
            'description' => 'Carved wood sculpture from Kandy.',
            'price' => 3500,
            'location' => 'Kandy',
            'phone_number' => '0771234567',
            'status' => 'active',
        ]);

        // Filter by District "Gampaha": should find both Gampaha city and child area Veyangoda
        $districtResults = Listing::filterByLocation('Gampaha')->pluck('id');
        $this->assertTrue($districtResults->contains($adInVeyangoda->id));
        $this->assertTrue($districtResults->contains($adInGampahaCity->id));
        $this->assertFalse($districtResults->contains($adInKandy->id));

        // Filter specifically by Area "Veyangoda": should find only Veyangoda
        $areaResults = Listing::filterByLocation('Veyangoda')->pluck('id');
        $this->assertTrue($areaResults->contains($adInVeyangoda->id));
        $this->assertFalse($areaResults->contains($adInGampahaCity->id));
        $this->assertFalse($areaResults->contains($adInKandy->id));
    }
}
