<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryFilter;
use App\Models\CategoryFilterOption;
use Illuminate\Support\Str;

class CategoryFilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing filters and options to ensure a clean state
        CategoryFilterOption::truncate();
        CategoryFilter::query()->delete();

        $districts = [
            'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya', 
            'Galle', 'Matara', 'Hambantota', 'Jaffna', 'Mannar', 'Vavuniya', 
            'Mullaitivu', 'Kilinochchi', 'Batticaloa', 'Ampara', 'Trincomalee', 
            'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla', 
            'Monaragala', 'Rathnapura', 'Kegalle'
        ];

        $categoriesData = [
            'Vehicles' => [
                ['name' => 'brand', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Toyota', 'Honda', 'Suzuki', 'Yamaha', 'Nissan', 'BMW', 'Mercedes', 'Ford', 'Chevrolet', 'Other']],
                ['name' => 'model', 'type' => 'text', 'placeholder' => 'e.g., Corolla, Civic, Alto', 'options' => []],
                ['name' => 'type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Sedan', 'SUV', 'Hatchback', 'Motorcycle', 'Truck', 'Van', 'Pickup']],
                ['name' => 'condition', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['New', 'Used', 'Recondition']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'fuel_type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Petrol', 'Diesel', 'Electric', 'Hybrid']],
                ['name' => 'gear_type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Automatic', 'Manual', 'CVT']],
                ['name' => 'year_min', 'type' => 'number', 'placeholder' => '2000', 'options' => []],
                ['name' => 'year_max', 'type' => 'number', 'placeholder' => '2025', 'options' => []],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '100000000', 'options' => []],
            ],
            'Property' => [
                ['name' => 'type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Apartment', 'House', 'Land', 'Commercial', 'Villa', 'Plot']],
                ['name' => 'bedrooms', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['1', '2', '3', '4', '5+', 'Any']],
                ['name' => 'furnished', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Yes', 'No', 'Semi-Furnished']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '100000000', 'options' => []],
                ['name' => 'area', 'type' => 'number', 'placeholder' => 'Min sq ft', 'options' => []],
                ['name' => 'build_year', 'type' => 'number', 'placeholder' => 'Year built', 'options' => []],
            ],
            'Electronics' => [
                ['name' => 'brand', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Samsung', 'Apple', 'Sony', 'LG', 'HP', 'Dell', 'Lenovo', 'ASUS', 'Xiaomi', 'Other']],
                ['name' => 'condition', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['New', 'Used', 'Recondition']],
                ['name' => 'type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Laptop', 'Phone', 'Tablet', 'TV', 'Camera', 'Speaker', 'Console']],
                ['name' => 'warranty', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Yes', 'No', 'Extended']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '100000000', 'options' => []],
            ],
            'Fashion & Beauty' => [
                ['name' => 'category', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Dress', 'Shirt', 'Pants', 'Shoes', 'Bag', 'Jewelry', 'Watch', 'Cosmetic']],
                ['name' => 'size', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size']],
                ['name' => 'gender', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Men', 'Women', 'Unisex', 'Kids']],
                ['name' => 'material', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Cotton', 'Silk', 'Denim', 'Leather', 'Wool', 'Polyester']],
                ['name' => 'condition', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['New', 'Like New', 'Used']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '100000000', 'options' => []],
            ],
            'Homemade Food' => [
                ['name' => 'type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Sweet', 'Savory', 'Beverage', 'Snack', 'Preserves', 'Spice Mix']],
                ['name' => 'dietary', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Vegan', 'Vegetarian', 'Gluten-Free', 'Sugar-Free', 'Organic']],
                ['name' => 'shelf_life', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['1 Day', '3 Days', '7 Days', '15 Days', '30 Days']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '50000', 'options' => []],
            ],
            'Handicrafts & Art' => [
                ['name' => 'material', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Wood', 'Metal', 'Clay', 'Fabric', 'Paper', 'Glass', 'Candle']],
                ['name' => 'style', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Traditional', 'Modern', 'Minimalist', 'Ethnic', 'Abstract']],
                ['name' => 'size', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Small', 'Medium', 'Large', 'Custom']],
                ['name' => 'color', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Natural', 'Painted', 'Polished', 'Multi-color']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '500000', 'options' => []],
            ],
            'Home Decor' => [
                ['name' => 'room', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Living Room', 'Bedroom', 'Kitchen', 'Bathroom', 'Garden', 'Office']],
                ['name' => 'style', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Modern', 'Traditional', 'Minimalist', 'Rustic', 'Bohemian']],
                ['name' => 'material', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Wood', 'Glass', 'Metal', 'Fabric', 'Ceramic', 'Plant']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '500000', 'options' => []],
            ],
            'Textiles & Handloom' => [
                ['name' => 'type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Sari', 'Shirt', 'Scarf', 'Blanket', 'Rug', 'Curtain', 'Cushion']],
                ['name' => 'material', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Cotton', 'Silk', 'Wool', 'Jute', 'Bamboo', 'Rayon']],
                ['name' => 'pattern', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Plain', 'Striped', 'Floral', 'Geometric', 'Ethnic']],
                ['name' => 'size', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Small', 'Medium', 'Large', 'Custom']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '200000', 'options' => []],
            ],
            'Essentials' => [
                ['name' => 'type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Kitchen', 'Cleaning', 'Personal Care', 'Storage', 'Organization']],
                ['name' => 'brand', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Local', 'Imported', 'Organic', 'Generic']],
                ['name' => 'quantity', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Single', 'Pack of 2', 'Pack of 5', 'Pack of 10']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '100000', 'options' => []],
            ],
            'Pets' => [
                ['name' => 'type', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Dog', 'Cat', 'Bird', 'Fish', 'Rabbit', 'Guinea Pig']],
                ['name' => 'age', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Puppy/Kitten', 'Adult', 'Senior']],
                ['name' => 'gender', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Male', 'Female', 'Unknown']],
                ['name' => 'vaccinated', 'type' => 'dropdown', 'placeholder' => null, 'options' => ['Yes', 'No', 'Partial']],
                ['name' => 'location', 'type' => 'dropdown', 'placeholder' => null, 'options' => $districts],
                ['name' => 'min_price', 'type' => 'number', 'placeholder' => '0', 'options' => []],
                ['name' => 'max_price', 'type' => 'number', 'placeholder' => '500000', 'options' => []],
            ],
        ];

        foreach ($categoriesData as $catName => $filters) {
            $category = Category::firstOrCreate([
                'slug' => Str::slug($catName),
            ], [
                'name' => $catName,
                'description' => $catName . ' category',
            ]);

            foreach ($filters as $index => $filterData) {
                $filter = $category->filters()->create([
                    'filter_name' => $filterData['name'],
                    'filter_type' => $filterData['type'],
                    'placeholder' => $filterData['placeholder'],
                    'sort_order'  => $index,
                ]);

                if (!empty($filterData['options'])) {
                    foreach ($filterData['options'] as $optIndex => $option) {
                        $filter->options()->create([
                            'option_value' => $option,
                            'sort_order' => $optIndex,
                        ]);
                    }
                }
            }
        }
    }
}
