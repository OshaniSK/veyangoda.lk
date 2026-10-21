<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryAndSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryData = [
            [
                'name' => 'Vehicles',
                'slug' => 'vehicles',
                'icon' => '🚗',
                'subcategories' => [
                    ['name' => 'Cars', 'slug' => 'cars', 'icon' => '🚙'],
                    ['name' => 'Motorbikes & Scooters', 'slug' => 'motorbikes-scooters', 'icon' => '🏍️'],
                    ['name' => 'Three Wheelers', 'slug' => 'three-wheelers', 'icon' => '🛺'],
                    ['name' => 'Push Cycles', 'slug' => 'push-cycles', 'icon' => '🚲'],
                    ['name' => 'Vans, Buses & Lorries', 'slug' => 'vans-buses-lorries', 'icon' => '🚐'],
                    ['name' => 'Heavy Machinery & Tractors', 'slug' => 'heavy-machinery-tractors', 'icon' => '🚜'],
                    ['name' => 'Auto Services', 'slug' => 'auto-services', 'icon' => '🔧'],
                    ['name' => 'Auto Parts & Accessories', 'slug' => 'auto-parts-accessories', 'icon' => '⚙️'],
                    ['name' => 'Boats & Water Transport', 'slug' => 'boats-water-transport', 'icon' => '🚤'],
                ],
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'icon' => '💻',
                'subcategories' => [
                    ['name' => 'Mobile Phones & Accessories', 'slug' => 'mobile-phones-accessories', 'icon' => '📱'],
                    ['name' => 'Computers & Laptops', 'slug' => 'computers-laptops', 'icon' => '💻'],
                    ['name' => 'TVs & Audio', 'slug' => 'tvs-audio', 'icon' => '📺'],
                    ['name' => 'Cameras & Photography', 'slug' => 'cameras-photography', 'icon' => '📷'],
                    ['name' => 'Gaming Consoles & Accessories', 'slug' => 'gaming-consoles-accessories', 'icon' => '🎮'],
                    ['name' => 'Home Appliances', 'slug' => 'home-appliances', 'icon' => '🔌'],
                    ['name' => 'Printers & Office Equipment', 'slug' => 'printers-office-equipment', 'icon' => '🖨️'],
                ],
            ],
            [
                'name' => 'Property',
                'slug' => 'property',
                'icon' => '🏠',
                'subcategories' => [
                    ['name' => 'Land & Plots', 'slug' => 'land-plots', 'icon' => '🏡'],
                    ['name' => 'Houses For Sale', 'slug' => 'houses-for-sale', 'icon' => '🏘️'],
                    ['name' => 'Apartments For Sale', 'slug' => 'apartments-for-sale', 'icon' => '🏢'],
                    ['name' => 'Rooms For Rent', 'slug' => 'rooms-for-rent', 'icon' => '🏠'],
                    ['name' => 'Offices & Commercial', 'slug' => 'offices-commercial', 'icon' => '🏢'],
                    ['name' => 'Factories & Warehouses', 'slug' => 'factories-warehouses', 'icon' => '🏭'],
                    ['name' => 'Farms & Agricultural Land', 'slug' => 'farms-agricultural-land', 'icon' => '🌾'],
                ],
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'icon' => '🏡',
                'subcategories' => [
                    ['name' => 'Furniture', 'slug' => 'furniture', 'icon' => '🛋️'],
                    ['name' => 'Kitchen & Dining', 'slug' => 'kitchen-dining', 'icon' => '🍽️'],
                    ['name' => 'Garden & Outdoor', 'slug' => 'garden-outdoor', 'icon' => '🌺'],
                    ['name' => 'Bathroom & Plumbing', 'slug' => 'bathroom-plumbing', 'icon' => '🛁'],
                    ['name' => 'Lighting & Electrical', 'slug' => 'lighting-electrical', 'icon' => '💡'],
                    ['name' => 'Cleaning & Household Supplies', 'slug' => 'cleaning-household-supplies', 'icon' => '🧹'],
                ],
            ],
            [
                'name' => 'Fashion, Health & Beauty',
                'slug' => 'fashion-health-beauty',
                'icon' => '👗',
                'subcategories' => [
                    ['name' => "Men's Clothing", 'slug' => 'mens-clothing', 'icon' => '👔'],
                    ['name' => "Women's Clothing", 'slug' => 'womens-clothing', 'icon' => '👗'],
                    ['name' => "Kids' Clothing", 'slug' => 'kids-clothing', 'icon' => '👶'],
                    ['name' => 'Shoes & Footwear', 'slug' => 'shoes-footwear', 'icon' => '👟'],
                    ['name' => 'Beauty & Cosmetics', 'slug' => 'beauty-cosmetics', 'icon' => '💄'],
                    ['name' => 'Health & Medical Supplies', 'slug' => 'health-medical-supplies', 'icon' => '💊'],
                ],
            ],
            [
                'name' => 'Hobby, Sport & Kids',
                'slug' => 'hobby-sport-kids',
                'icon' => '⚽',
                'subcategories' => [
                    ['name' => 'Sports Equipment', 'slug' => 'sports-equipment', 'icon' => '🎾'],
                    ['name' => 'Art & Craft Supplies', 'slug' => 'art-craft-supplies', 'icon' => '🎨'],
                    ['name' => "Kids' Toys & Games", 'slug' => 'kids-toys-games', 'icon' => '🧸'],
                    ['name' => 'Musical Instruments', 'slug' => 'musical-instruments', 'icon' => '🎸'],
                    ['name' => 'Books & Stationery', 'slug' => 'books-stationery', 'icon' => '📚'],
                    ['name' => 'Hobbies & Collectibles', 'slug' => 'hobbies-collectibles', 'icon' => '🎯'],
                ],
            ],
            [
                'name' => 'Business & Industry',
                'slug' => 'business-industry',
                'icon' => '🏭',
                'subcategories' => [
                    ['name' => 'Business Services', 'slug' => 'business-services', 'icon' => '🏢'],
                    ['name' => 'Wholesale & Bulk Supplies', 'slug' => 'wholesale-bulk-supplies', 'icon' => '📦'],
                    ['name' => 'Construction Materials', 'slug' => 'construction-materials', 'icon' => '🏗️'],
                    ['name' => 'Agricultural Equipment', 'slug' => 'agricultural-equipment', 'icon' => '🚜'],
                    ['name' => 'Restaurant & Hotel Supplies', 'slug' => 'restaurant-hotel-supplies', 'icon' => '🍳'],
                    ['name' => 'Business Consulting', 'slug' => 'business-consulting', 'icon' => '📊'],
                ],
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'icon' => '🔧',
                'subcategories' => [
                    ['name' => 'Repair Services', 'slug' => 'repair-services', 'icon' => '🛠️'],
                    ['name' => 'Cleaning Services', 'slug' => 'cleaning-services', 'icon' => '🧹'],
                    ['name' => 'Photography & Videography', 'slug' => 'photography-videography', 'icon' => '📸'],
                    ['name' => 'Tutoring & Education', 'slug' => 'tutoring-education', 'icon' => '🎓'],
                    ['name' => 'Financial Services', 'slug' => 'financial-services', 'icon' => '💰'],
                    ['name' => 'Health & Wellness', 'slug' => 'health-wellness', 'icon' => '🏥'],
                    ['name' => 'Transport & Moving Services', 'slug' => 'transport-moving-services', 'icon' => '🚚'],
                    ['name' => 'Event & Party Services', 'slug' => 'event-party-services', 'icon' => '🎉'],
                ],
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'icon' => '🎓',
                'subcategories' => [
                    ['name' => 'Courses & Classes', 'slug' => 'courses-classes', 'icon' => '📚'],
                    ['name' => 'University Programs', 'slug' => 'university-programs', 'icon' => '🎓'],
                    ['name' => 'Textbooks & Study Materials', 'slug' => 'textbooks-study-materials', 'icon' => '📖'],
                    ['name' => 'Language Learning', 'slug' => 'language-learning', 'icon' => '🌍'],
                    ['name' => 'Online Courses & Tutorials', 'slug' => 'online-courses-tutorials', 'icon' => '💻'],
                    ['name' => 'Arts & Music Lessons', 'slug' => 'arts-music-lessons', 'icon' => '🎨'],
                    ['name' => 'Exam Preparation', 'slug' => 'exam-preparation', 'icon' => '📝'],
                ],
            ],
            [
                'name' => 'Animals',
                'slug' => 'animals',
                'icon' => '🐾',
                'subcategories' => [
                    ['name' => 'Dogs & Puppies', 'slug' => 'dogs-puppies', 'icon' => '🐶'],
                    ['name' => 'Cats & Kittens', 'slug' => 'cats-kittens', 'icon' => '🐱'],
                    ['name' => 'Birds', 'slug' => 'birds', 'icon' => '🐦'],
                    ['name' => 'Fish & Aquariums', 'slug' => 'fish-aquariums', 'icon' => '🐠'],
                    ['name' => 'Horses & Livestock', 'slug' => 'horses-livestock', 'icon' => '🐴'],
                    ['name' => 'Pet Food & Supplies', 'slug' => 'pet-food-supplies', 'icon' => '🍖'],
                ],
            ],
        ];

        foreach ($categoryData as $catItem) {
            $category = Category::updateOrCreate(
                ['slug' => $catItem['slug']],
                [
                    'name' => $catItem['name'],
                    'icon' => $catItem['icon'],
                ]
            );

            foreach ($catItem['subcategories'] as $subItem) {
                SubCategory::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'slug'        => $subItem['slug'],
                    ],
                    [
                        'name' => $subItem['name'],
                        'icon' => $subItem['icon'],
                    ]
                );
            }
        }
    }
}
