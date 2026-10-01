<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Seller / Users with phone_number
        $seller1 = User::firstOrCreate(
            ['email' => 'ayesha.crafts@example.com'],
            [
                'name' => 'Ayesha Fernando',
                'password' => Hash::make('password123'),
                'phone_number' => '0771234567',
                'phone' => '0771234567',
                'location_city' => 'Kandy',
            ]
        );

        $seller2 = User::firstOrCreate(
            ['email' => 'sunil.woodworks@example.com'],
            [
                'name' => 'Sunil Jayawardena',
                'password' => Hash::make('password123'),
                'phone_number' => '0719876543',
                'phone' => '0719876543',
                'location_city' => 'Moratuwa',
            ]
        );

        // 2. Seed marketplace categories
        $categoriesData = [
            ['name' => 'Home Decor', 'slug' => 'home-decor'],
            ['name' => 'Textiles & Handloom', 'slug' => 'textiles-handloom'],
            ['name' => 'Homemade Food', 'slug' => 'homemade-food'],
            ['name' => 'Handicrafts & Art', 'slug' => 'handicrafts-art'],
            ['name' => 'Fashion & Beauty', 'slug' => 'fashion-beauty'],
            ['name' => 'Essentials', 'slug' => 'essentials'],
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Vehicles', 'slug' => 'vehicles'],
            ['name' => 'Property', 'slug' => 'property'],
            ['name' => 'Pets', 'slug' => 'pets'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // 3. Seed Active Listings
        $sampleAds = [
            [
                'user_id' => $seller1->id,
                'category_id' => $categories['home-decor']->id,
                'title' => 'Botanical Soy Wax Scented Candles (Set of 3)',
                'slug' => 'botanical-soy-wax-scented-candles-set-of-3',
                'description' => 'Crafted with 100% pure organic soy wax and scented with natural Ceylon cinnamon and lemongrass essential oils. Burn time approx 35 hours each.',
                'price' => 3200.00,
                'location' => 'Kandy',
                'image_path' => 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=600&q=80',
                'status' => 'active',
            ],
            [
                'user_id' => $seller2->id,
                'category_id' => $categories['home-decor']->id,
                'title' => 'Hand-Carved Reclaimed Teak Salad Bowls',
                'slug' => 'hand-carved-reclaimed-teak-salad-bowls',
                'description' => 'Made from aged reclaimed Ceylon teak wood with natural beeswax food-safe polish. Perfect for salads and dining table displays.',
                'price' => 4850.00,
                'location' => 'Moratuwa, Colombo',
                'image_path' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?auto=format&fit=crop&w=600&q=80',
                'status' => 'active',
            ],
            [
                'user_id' => $seller1->id,
                'category_id' => $categories['homemade-food']->id,
                'title' => 'Organic Homemade Spiced Mango Chutney 350g Jar',
                'slug' => 'organic-homemade-spiced-mango-chutney-350g-jar',
                'description' => 'Traditional domestic family recipe prepared in clay pots without artificial colors or preservatives. Mild spicy and tangy sweetness.',
                'price' => 850.00,
                'location' => 'Matale',
                'image_path' => 'https://images.unsplash.com/photo-1546548970-71785318a17b?auto=format&fit=crop&w=600&q=80',
                'status' => 'active',
            ],
            [
                'user_id' => $seller2->id,
                'category_id' => $categories['textiles-handloom']->id,
                'title' => 'Pure Cotton Handloom Table Runner & 6 Napkins',
                'slug' => 'pure-cotton-handloom-table-runner-6-napkins',
                'description' => 'Woven on traditional wooden pit looms with earth-toned natural dyes. Includes 1 long table runner (180cm) and 6 matching napkins.',
                'price' => 2950.00,
                'location' => 'Kurunegala',
                'image_path' => 'https://images.unsplash.com/photo-1584992236310-6edddc08acff?auto=format&fit=crop&w=600&q=80',
                'status' => 'active',
            ],
        ];

        foreach ($sampleAds as $ad) {
            Listing::updateOrCreate(['slug' => $ad['slug']], $ad);
        }
    }
}
