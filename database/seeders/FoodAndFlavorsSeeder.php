<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategoryFilter;
use App\Models\CategoryFilterOption;
use Illuminate\Support\Str;

class FoodAndFlavorsSeeder extends Seeder
{
    public function run(): void
    {
        $parent = Category::where('slug', 'food-and-flavours')->first();

        if (!$parent) {
            $parent = Category::create([
                'name' => 'Food & Flavours',
                'slug' => 'food-and-flavours',
                'icon' => 'ðŸ½ï¸',
                'description' => 'Explore a world of tastes, from homemade meals to restaurant deliveries.'
            ]);
        }

        // Wipe old subcategories and filters for this parent to ensure clean state
        SubCategory::where('category_id', $parent->id)->delete();
        // Also wipe any old direct filters on this category (like from previous CategoryFilterSeeder)
        CategoryFilter::where('category_id', $parent->id)->whereNull('sub_category_id')->delete();

        $districts = [
            'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya',
            'Galle', 'Matara', 'Hambantota', 'Jaffna', 'Mannar', 'Vavuniya',
            'Mullaitivu', 'Kilinochchi', 'Batticaloa', 'Ampara', 'Trincomalee',
            'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla',
            'Monaragala', 'Rathnapura', 'Kegalle'
        ];

        $subCategoriesData = [
            [
                'name' => 'Homemade Food',
                'icon' => 'ðŸ ',
                'filters' => [
                    ['name' => 'item_type', 'label' => 'Type', 'type' => 'dropdown', 'options' => ['Sweet', 'Savory', 'Beverage', 'Snack', 'Preserves']],
                    ['name' => 'dietary', 'label' => 'Dietary', 'type' => 'dropdown', 'options' => ['Vegan', 'Vegetarian', 'Gluten-Free', 'Sugar-Free', 'Organic']],
                    ['name' => 'shelf_life', 'label' => 'Shelf Life', 'type' => 'dropdown', 'options' => ['1 Day', '3 Days', '7 Days', '15 Days', '30 Days']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Restaurants',
                'icon' => 'ðŸ´',
                'filters' => [
                    ['name' => 'cuisine', 'label' => 'Cuisine', 'type' => 'dropdown', 'options' => ['Sri Lankan', 'Indian', 'Chinese', 'Thai', 'Western', 'Japanese', 'Italian']],
                    ['name' => 'meal_type', 'label' => 'Meal Type', 'type' => 'dropdown', 'options' => ['Breakfast', 'Lunch', 'Dinner', 'Snack', 'Dessert', 'Beverage']],
                    ['name' => 'dietary', 'label' => 'Dietary', 'type' => 'dropdown', 'options' => ['Vegetarian', 'Non-Vegetarian', 'Vegan', 'Halal', 'Gluten-Free']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Cakes & Desserts',
                'icon' => 'ðŸŽ‚',
                'filters' => [
                    ['name' => 'flavor', 'label' => 'Flavor', 'type' => 'dropdown', 'options' => ['Chocolate', 'Vanilla', 'Strawberry', 'Fruit', 'Nut', 'Coffee']],
                    ['name' => 'item_type', 'label' => 'Type', 'type' => 'dropdown', 'options' => ['Cake', 'Cupcake', 'Pie', 'Tart', 'Mousse', 'Macaron']],
                    ['name' => 'dietary', 'label' => 'Dietary', 'type' => 'dropdown', 'options' => ['Gluten-Free', 'Sugar-Free', 'Vegan']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Takeaway & Delivery',
                'icon' => 'ðŸ›µ',
                'filters' => [
                    ['name' => 'cuisine', 'label' => 'Cuisine', 'type' => 'dropdown', 'options' => ['Sri Lankan', 'Fast Food', 'Chinese', 'Indian']],
                    ['name' => 'meal_type', 'label' => 'Meal Type', 'type' => 'dropdown', 'options' => ['Lunch Box', 'Dinner Box', 'Snack Pack']],
                    ['name' => 'dietary', 'label' => 'Dietary', 'type' => 'dropdown', 'options' => ['Vegetarian', 'Non-Vegetarian']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Rice & Curry / Meal Boxes',
                'icon' => 'ðŸ›',
                'filters' => [
                    ['name' => 'curry_type', 'label' => 'Curry Type', 'type' => 'dropdown', 'options' => ['Chicken', 'Beef', 'Crab', 'Fish', 'Vegetable', 'Lobster']],
                    ['name' => 'rice_type', 'label' => 'Rice Type', 'type' => 'dropdown', 'options' => ['White', 'Red', 'Coconut', 'Pulav', 'Fried']],
                    ['name' => 'spice_level', 'label' => 'Spice Level', 'type' => 'dropdown', 'options' => ['Mild', 'Medium', 'Hot', 'Extra Hot']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Drinks & Beverages',
                'icon' => 'ðŸ¥¤',
                'filters' => [
                    ['name' => 'item_type', 'label' => 'Type', 'type' => 'dropdown', 'options' => ['Juice', 'Smoothie', 'Coffee', 'Tea', 'Milkshake', 'Soda', 'Alcohol']],
                    ['name' => 'temperature', 'label' => 'Temperature', 'type' => 'dropdown', 'options' => ['Hot', 'Cold', 'Iced']],
                    ['name' => 'flavor', 'label' => 'Flavor', 'type' => 'dropdown', 'options' => ['Fruit', 'Floral', 'Spiced', 'Plain']],
                    ['name' => 'size', 'label' => 'Size', 'type' => 'dropdown', 'options' => ['Small', 'Medium', 'Large']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Bakery & Snacks',
                'icon' => 'ðŸ¥',
                'filters' => [
                    ['name' => 'item_type', 'label' => 'Type', 'type' => 'dropdown', 'options' => ['Bread', 'Croissant', 'Muffin', 'Cookie', 'Biscuit', 'Pastry', 'Sandwich', 'Roll']],
                    ['name' => 'flavor', 'label' => 'Flavor', 'type' => 'dropdown', 'options' => ['Cheese', 'Ham', 'Veggie', 'Chocolate', 'Cinnamon', 'Plain']],
                    ['name' => 'dietary', 'label' => 'Dietary', 'type' => 'dropdown', 'options' => ['Vegan', 'Gluten-Free', 'Nut-Free']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Catering',
                'icon' => 'ðŸ±',
                'filters' => [
                    ['name' => 'event_type', 'label' => 'Event Type', 'type' => 'dropdown', 'options' => ['Wedding', 'Birthday', 'Corporate', 'Funeral', 'Party']],
                    ['name' => 'service_type', 'label' => 'Service Type', 'type' => 'dropdown', 'options' => ['Buffet', 'Plated', 'Boxed', 'Finger Food']],
                    ['name' => 'dietary', 'label' => 'Dietary', 'type' => 'dropdown', 'options' => ['Vegetarian', 'Non-Vegetarian', 'Mixed']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
            [
                'name' => 'Traditional & Local Food',
                'icon' => 'ðŸ²',
                'filters' => [
                    ['name' => 'item_type', 'label' => 'Type', 'type' => 'dropdown', 'options' => ['Kottu', 'Hoppers', 'String Hoppers', 'Watalappan', 'Kokis', 'Kavum', 'Aluwa', 'Patani']],
                    ['name' => 'occasion', 'label' => 'Occasion', 'type' => 'dropdown', 'options' => ['Poya', 'Festival', 'Daily', 'Breakfast', 'Tea Time']],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'dropdown', 'options' => $districts],
                    ['name' => 'price_min', 'label' => 'Min Price', 'type' => 'number'],
                    ['name' => 'price_max', 'label' => 'Max Price', 'type' => 'number'],
                ]
            ],
        ];

        foreach ($subCategoriesData as $subIndex => $subData) {
            $subCategory = SubCategory::create([
                'category_id' => $parent->id,
                'name' => $subData['name'],
                'slug' => Str::slug($subData['name']),
                'icon' => $subData['icon']
            ]);

            foreach ($subData['filters'] as $fIndex => $filterData) {
                // Determine column matching
                $columnMap = [
                    'price_min' => 'price',
                    'price_max' => 'price',
                ];
                $actualName = $filterData['name']; // will use this for form input name
                
                $filter = CategoryFilter::create([
                    'category_id' => $parent->id,
                    'sub_category_id' => $subCategory->id,
                    'filter_name' => $filterData['label'],
                    'filter_type' => $filterData['type'],
                    'sort_order' => $fIndex,
                ]);

                // But wait! We've been using 'filter_name' loosely in UI?
                // The existing setup in category.blade.php uses strtolower(str_replace(' ', '_', $filter->filter_name))
                // Let's modify filter_name directly or just let UI derive it?
                // In previous seeder we just used 'Brand', 'Model'. 
                // We'll stick to string label in 'filter_name' and let the UI slugify it.
                // Wait, if it slugifies "Min Price" to "min_price", but the backend expects "price_min".
                // We should rename the label to "Min Price" but ensure backend can match it.
                // Actually, existing backend uses `price_min` and `price_max` directly from request, not dynamically via DB columns except for dropdowns.
                
                if (isset($filterData['options'])) {
                    foreach ($filterData['options'] as $oIndex => $option) {
                        CategoryFilterOption::create([
                            'category_filter_id' => $filter->id,
                            'option_value' => $option,
                            'sort_order' => $oIndex
                        ]);
                    }
                }
            }
        }
    }
}
