<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FoodItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating food categories...');

        // Create categories
        $categories = $this->createFoodCategories();

        $this->command->info('Creating food items...');

        // Find admin user for created_by field
        $admin = User::where('email', 'aymanelh0001@gmail.com')->first();
        $createdBy = $admin ? $admin->id : null;

        // Create food items for each category
        foreach ($categories as $categoryId => $categoryItems) {
            $this->command->info("Creating foods in category: {$categoryItems['name']}");

            foreach ($categoryItems['items'] as $item) {
                $this->createFoodItem($item, $categoryId, $createdBy);
            }
        }

        $this->command->info('Food items seeding completed successfully!');
    }

    /**
     * Create food categories.
     *
     * @return array
     */
    private function createFoodCategories(): array
    {
        $categories = [
            [
                'name' => 'Fruits',
                'description' => 'Fresh and dried fruits',
                'color_code' => '#4CAF50',
                'display_order' => 1,
            ],
            [
                'name' => 'Vegetables',
                'description' => 'Fresh, frozen, and canned vegetables',
                'color_code' => '#8BC34A',
                'display_order' => 2,
            ],
            [
                'name' => 'Protein Foods',
                'description' => 'Meat, poultry, seafood, eggs, and plant-based proteins',
                'color_code' => '#F44336',
                'display_order' => 3,
            ],
            [
                'name' => 'Dairy',
                'description' => 'Milk, cheese, yogurt, and dairy alternatives',
                'color_code' => '#2196F3',
                'display_order' => 4,
            ],
            [
                'name' => 'Grains',
                'description' => 'Whole grains, cereals, bread, and pasta',
                'color_code' => '#FFC107',
                'display_order' => 5,
            ],
            [
                'name' => 'Snacks',
                'description' => 'Chips, crackers, nuts, and other snack foods',
                'color_code' => '#FF9800',
                'display_order' => 6,
            ],
            [
                'name' => 'Beverages',
                'description' => 'Water, coffee, tea, juice, and other drinks',
                'color_code' => '#03A9F4',
                'display_order' => 7,
            ],
        ];

        $categoryMap = [];

        foreach ($categories as $category) {
            $newCategory = FoodCategory::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'color_code' => $category['color_code']
            ]);

            $categoryMap[$newCategory->id] = [
                'name' => $category['name'],
                'items' => $this->getFoodItemsForCategory($category['name']),
            ];
        }

        return $categoryMap;
    }

    /**
     * Create a food item.
     *
     * @param array $item
     * @param int $categoryId
     * @param int|null $createdBy
     * @return void
     */
    private function createFoodItem(array $item, int $categoryId, ?int $createdBy): void
    {
        Food::create([
            'name' => $item['name'],
            'slug' => Str::slug($item['name']),
            'category_id' => $categoryId,
            'brand' => $item['brand'] ?? null,
            'portion_default' => $item['portion_default'],
            'portions' => $item['portions'] ?? null,
            'nutrients' => $item['nutrients'],
            'micronutrients' => $item['micronutrients'] ?? null,
            'description' => $item['description'] ?? null,
            'image_url' => $item['image_url'] ?? null,
            'created_by' => $createdBy,
        ]);
    }

    /**
     * Get food items for a specific category.
     *
     * @param string $categoryName
     * @return array
     */
    private function getFoodItemsForCategory(string $categoryName): array
    {
        $foods = [
            'Fruits' => [
                [
                    'name' => 'Apple',
                    'portion_default' => '1 medium (182g)',
                    'portions' => [
                        ['name' => 'medium', 'weight_g' => 182, 'measure' => '1 medium'],
                        ['name' => 'large', 'weight_g' => 223, 'measure' => '1 large'],
                        ['name' => 'cup slices', 'weight_g' => 109, 'measure' => '1 cup, sliced'],
                    ],
                    'nutrients' => [
                        'calories' => 95,
                        'protein_g' => 0.5,
                        'carbs_g' => 25.1,
                        'fat_g' => 0.3,
                        'fiber_g' => 4.4,
                        'sugar_g' => 19,
                    ],
                    'micronutrients' => [
                        'vitamin_c_mg' => 8.4,
                        'potassium_mg' => 195,
                    ],
                    'description' => 'Fresh apple with skin, a good source of fiber and vitamin C.',
                    'image_url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6',
                ],
                [
                    'name' => 'Banana',
                    'portion_default' => '1 medium (118g)',
                    'portions' => [
                        ['name' => 'medium', 'weight_g' => 118, 'measure' => '1 medium'],
                        ['name' => 'large', 'weight_g' => 136, 'measure' => '1 large'],
                        ['name' => 'cup slices', 'weight_g' => 150, 'measure' => '1 cup, sliced'],
                    ],
                    'nutrients' => [
                        'calories' => 105,
                        'protein_g' => 1.3,
                        'carbs_g' => 27,
                        'fat_g' => 0.4,
                        'fiber_g' => 3.1,
                        'sugar_g' => 14.4,
                    ],
                    'micronutrients' => [
                        'vitamin_b6_mg' => 0.4,
                        'potassium_mg' => 422,
                    ],
                    'description' => 'Fresh banana, good source of potassium and vitamin B6.',
                    'image_url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e',
                ],
                [
                    'name' => 'Strawberries',
                    'portion_default' => '1 cup (152g)',
                    'nutrients' => [
                        'calories' => 49,
                        'protein_g' => 1,
                        'carbs_g' => 11.7,
                        'fat_g' => 0.5,
                        'fiber_g' => 3,
                        'sugar_g' => 7.4,
                    ],
                    'description' => 'Fresh strawberries, high in vitamin C and antioxidants.',
                    'image_url' => 'https://images.unsplash.com/photo-1518635017498-87f514b751ba',
                ],
                [
                    'name' => 'Blueberries',
                    'portion_default' => '1 cup (148g)',
                    'nutrients' => [
                        'calories' => 84,
                        'protein_g' => 1.1,
                        'carbs_g' => 21.4,
                        'fat_g' => 0.5,
                        'fiber_g' => 3.6,
                        'sugar_g' => 14.7,
                    ],
                    'description' => 'Fresh blueberries, high in antioxidants and vitamins.',
                ],
                [
                    'name' => 'Avocado',
                    'portion_default' => '1/2 medium (68g)',
                    'nutrients' => [
                        'calories' => 114,
                        'protein_g' => 1.3,
                        'carbs_g' => 6,
                        'fat_g' => 10.5,
                        'fiber_g' => 4.6,
                        'sugar_g' => 0.2,
                    ],
                    'description' => 'Creamy, nutrient-dense fruit high in healthy fats.',
                ],
            ],
            'Vegetables' => [
                [
                    'name' => 'Broccoli',
                    'portion_default' => '1 cup chopped (91g)',
                    'nutrients' => [
                        'calories' => 31,
                        'protein_g' => 2.5,
                        'carbs_g' => 6,
                        'fat_g' => 0.3,
                        'fiber_g' => 2.4,
                        'sugar_g' => 1.5,
                    ],
                    'micronutrients' => [
                        'vitamin_c_mg' => 81.2,
                        'vitamin_k_mcg' => 92.5,
                    ],
                    'description' => 'Nutritious cruciferous vegetable rich in vitamins and minerals.',
                    'image_url' => 'https://images.unsplash.com/photo-1584270354949-c26b0d080b0a',
                ],
                [
                    'name' => 'Spinach',
                    'portion_default' => '1 cup (30g)',
                    'nutrients' => [
                        'calories' => 7,
                        'protein_g' => 0.9,
                        'carbs_g' => 1.1,
                        'fat_g' => 0.1,
                        'fiber_g' => 0.7,
                        'sugar_g' => 0.1,
                    ],
                    'description' => 'Leafy green vegetable packed with iron and vitamins.',
                ],
                [
                    'name' => 'Sweet Potato',
                    'portion_default' => '1 medium (114g)',
                    'nutrients' => [
                        'calories' => 103,
                        'protein_g' => 2,
                        'carbs_g' => 24,
                        'fat_g' => 0.2,
                        'fiber_g' => 3.8,
                        'sugar_g' => 7.4,
                    ],
                    'description' => 'Root vegetable rich in vitamin A and complex carbohydrates.',
                ],
                [
                    'name' => 'Bell Pepper (Red)',
                    'portion_default' => '1 medium (119g)',
                    'nutrients' => [
                        'calories' => 37,
                        'protein_g' => 1.2,
                        'carbs_g' => 7.2,
                        'fat_g' => 0.4,
                        'fiber_g' => 2.5,
                        'sugar_g' => 4.2,
                    ],
                    'description' => 'Sweet, crunchy vegetable high in vitamin C.',
                ],
                [
                    'name' => 'Carrots',
                    'portion_default' => '1 medium (61g)',
                    'nutrients' => [
                        'calories' => 25,
                        'protein_g' => 0.6,
                        'carbs_g' => 6,
                        'fat_g' => 0.1,
                        'fiber_g' => 1.7,
                        'sugar_g' => 2.9,
                    ],
                    'description' => 'Root vegetable high in beta-carotene and vitamin A.',
                ],
            ],
            'Protein Foods' => [
                [
                    'name' => 'Chicken Breast',
                    'portion_default' => '3 oz (85g)',
                    'brand' => null,
                    'portions' => [
                        ['name' => 'oz', 'weight_g' => 28, 'measure' => '1 oz'],
                        ['name' => 'breast', 'weight_g' => 172, 'measure' => '1 breast half'],
                    ],
                    'nutrients' => [
                        'calories' => 165,
                        'protein_g' => 31,
                        'carbs_g' => 0,
                        'fat_g' => 3.6,
                        'fiber_g' => 0,
                        'sugar_g' => 0,
                    ],
                    'micronutrients' => [
                        'niacin_mg' => 13.4,
                        'vitamin_b6_mg' => 0.6,
                    ],
                    'description' => 'Skinless, boneless chicken breast, high in lean protein.',
                    'image_url' => 'https://images.unsplash.com/photo-1518492104633-130d8bcce2f8',
                ],
                [
                    'name' => 'Salmon',
                    'portion_default' => '3 oz (85g)',
                    'nutrients' => [
                        'calories' => 175,
                        'protein_g' => 18.8,
                        'carbs_g' => 0,
                        'fat_g' => 10.5,
                        'fiber_g' => 0,
                        'sugar_g' => 0,
                    ],
                    'description' => 'Fatty fish rich in omega-3 fatty acids and protein.',
                ],
                [
                    'name' => 'Ground Beef (90% lean)',
                    'portion_default' => '3 oz (85g)',
                    'nutrients' => [
                        'calories' => 184,
                        'protein_g' => 22.5,
                        'carbs_g' => 0,
                        'fat_g' => 10,
                        'fiber_g' => 0,
                        'sugar_g' => 0,
                    ],
                    'description' => 'Lean ground beef, good source of protein and iron.',
                ],
                [
                    'name' => 'Eggs',
                    'portion_default' => '1 large (50g)',
                    'nutrients' => [
                        'calories' => 72,
                        'protein_g' => 6.3,
                        'carbs_g' => 0.4,
                        'fat_g' => 5,
                        'fiber_g' => 0,
                        'sugar_g' => 0.2,
                    ],
                    'description' => 'Whole egg, complete protein source with essential nutrients.',
                ],
                [
                    'name' => 'Tofu',
                    'portion_default' => '3 oz (85g)',
                    'nutrients' => [
                        'calories' => 70,
                        'protein_g' => 8,
                        'carbs_g' => 2,
                        'fat_g' => 4,
                        'fiber_g' => 1,
                        'sugar_g' => 0,
                    ],
                    'description' => 'Plant-based protein made from soybeans.',
                ],
            ],
            'Dairy' => [
                [
                    'name' => 'Greek Yogurt (Plain, Nonfat)',
                    'brand' => 'Generic',
                    'portion_default' => '1 cup (245g)',
                    'nutrients' => [
                        'calories' => 133,
                        'protein_g' => 23,
                        'carbs_g' => 7.8,
                        'fat_g' => 0.4,
                        'fiber_g' => 0,
                        'sugar_g' => 7.8,
                    ],
                    'description' => 'Strained yogurt with high protein content and probiotics.',
                    'image_url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777',
                ],
                [
                    'name' => 'Cheddar Cheese',
                    'portion_default' => '1 oz (28g)',
                    'nutrients' => [
                        'calories' => 113,
                        'protein_g' => 7,
                        'carbs_g' => 0.4,
                        'fat_g' => 9,
                        'fiber_g' => 0,
                        'sugar_g' => 0.1,
                    ],
                    'description' => 'Aged cheese high in calcium and protein.',
                ],
                [
                    'name' => 'Whole Milk',
                    'portion_default' => '1 cup (244g)',
                    'nutrients' => [
                        'calories' => 146,
                        'protein_g' => 7.9,
                        'carbs_g' => 11.7,
                        'fat_g' => 7.9,
                        'fiber_g' => 0,
                        'sugar_g' => 12.3,
                    ],
                    'description' => 'Dairy milk containing protein, calcium, and vitamin D.',
                ],
                [
                    'name' => 'Cottage Cheese (1% fat)',
                    'portion_default' => '1/2 cup (113g)',
                    'nutrients' => [
                        'calories' => 81,
                        'protein_g' => 14,
                        'carbs_g' => 3.5,
                        'fat_g' => 1.2,
                        'fiber_g' => 0,
                        'sugar_g' => 3.1,
                    ],
                    'description' => 'Fresh cheese curd high in casein protein.',
                ],
            ],
            'Grains' => [
                [
                    'name' => 'Quinoa',
                    'portion_default' => '1/4 cup dry (45g)',
                    'nutrients' => [
                        'calories' => 156,
                        'protein_g' => 5.7,
                        'carbs_g' => 27.3,
                        'fat_g' => 2.5,
                        'fiber_g' => 2.8,
                        'sugar_g' => 0.9,
                    ],
                    'description' => 'Complete protein grain with all essential amino acids.',
                    'image_url' => 'https://images.unsplash.com/photo-1586201375761-83865001e8ac',
                ],
                [
                    'name' => 'Brown Rice',
                    'portion_default' => '1/4 cup dry (45g)',
                    'nutrients' => [
                        'calories' => 165,
                        'protein_g' => 3.5,
                        'carbs_g' => 35,
                        'fat_g' => 1.5,
                        'fiber_g' => 1.8,
                        'sugar_g' => 0.7,
                    ],
                    'description' => 'Whole grain rice with fiber and nutrients.',
                ],
                [
                    'name' => 'Oats',
                    'portion_default' => '1/2 cup dry (40g)',
                    'nutrients' => [
                        'calories' => 150,
                        'protein_g' => 5,
                        'carbs_g' => 27,
                        'fat_g' => 2.5,
                        'fiber_g' => 4,
                        'sugar_g' => 1,
                    ],
                    'description' => 'Whole grain oats high in soluble fiber.',
                ],
                [
                    'name' => 'Whole Wheat Bread',
                    'portion_default' => '1 slice (32g)',
                    'nutrients' => [
                        'calories' => 81,
                        'protein_g' => 4,
                        'carbs_g' => 15,
                        'fat_g' => 1.1,
                        'fiber_g' => 2,
                        'sugar_g' => 1.6,
                    ],
                    'description' => 'Bread made from whole wheat flour with higher fiber content.',
                ],
            ],
            'Snacks' => [
                [
                    'name' => 'Almonds',
                    'portion_default' => '1 oz (28g)',
                    'nutrients' => [
                        'calories' => 164,
                        'protein_g' => 6,
                        'carbs_g' => 6,
                        'fat_g' => 14,
                        'fiber_g' => 3.5,
                        'sugar_g' => 1.2,
                    ],
                    'description' => 'Tree nuts high in vitamin E and healthy fats.',
                    'image_url' => 'https://images.unsplash.com/photo-1574570071121-9a35b3a51ae6',
                ],
                [
                    'name' => 'Dark Chocolate (70% cocoa)',
                    'portion_default' => '1 oz (28g)',
                    'nutrients' => [
                        'calories' => 170,
                        'protein_g' => 2.2,
                        'carbs_g' => 13,
                        'fat_g' => 12,
                        'fiber_g' => 3,
                        'sugar_g' => 7,
                    ],
                    'description' => 'Chocolate with high cocoa content and antioxidants.',
                ],
                [
                    'name' => 'Hummus',
                    'portion_default' => '2 tbsp (30g)',
                    'nutrients' => [
                        'calories' => 70,
                        'protein_g' => 2,
                        'carbs_g' => 6,
                        'fat_g' => 5,
                        'fiber_g' => 1.5,
                        'sugar_g' => 0,
                    ],
                    'description' => 'Chickpea dip with tahini, olive oil, and spices.',
                ],
                [
                    'name' => 'Popcorn (Air-popped)',
                    'portion_default' => '3 cups (24g)',
                    'nutrients' => [
                        'calories' => 93,
                        'protein_g' => 3,
                        'carbs_g' => 19,
                        'fat_g' => 1.1,
                        'fiber_g' => 3.6,
                        'sugar_g' => 0.2,
                    ],
                    'description' => 'Whole grain snack low in calories when air-popped.',
                ],
            ],
            'Beverages' => [
                [
                    'name' => 'Green Tea',
                    'portion_default' => '1 cup (240ml)',
                    'nutrients' => [
                        'calories' => 2,
                        'protein_g' => 0,
                        'carbs_g' => 0,
                        'fat_g' => 0,
                        'fiber_g' => 0,
                        'sugar_g' => 0,
                    ],
                    'description' => 'Tea high in antioxidants with moderate caffeine content.',
                    'image_url' => 'https://images.unsplash.com/photo-1556881286-fc6915169721',
                ],
                [
                    'name' => 'Coffee (Black)',
                    'portion_default' => '1 cup (240ml)',
                    'nutrients' => [
                        'calories' => 2,
                        'protein_g' => 0.3,
                        'carbs_g' => 0,
                        'fat_g' => 0,
                        'fiber_g' => 0,
                        'sugar_g' => 0,
                    ],
                    'description' => 'Brewed coffee without added ingredients.',
                ],
                [
                    'name' => 'Orange Juice (100%)',
                    'portion_default' => '1 cup (248g)',
                    'nutrients' => [
                        'calories' => 112,
                        'protein_g' => 1.7,
                        'carbs_g' => 26,
                        'fat_g' => 0.5,
                        'fiber_g' => 0.5,
                        'sugar_g' => 21,
                    ],
                    'description' => 'Juice from oranges, high in vitamin C.',
                ],
                [
                    'name' => 'Almond Milk (Unsweetened)',
                    'portion_default' => '1 cup (240ml)',
                    'nutrients' => [
                        'calories' => 30,
                        'protein_g' => 1,
                        'carbs_g' => 1,
                        'fat_g' => 2.5,
                        'fiber_g' => 0.5,
                        'sugar_g' => 0,
                    ],
                    'description' => 'Plant-based milk alternative made from almonds.',
                ],
                [
                    'name' => 'Protein Shake',
                    'brand' => 'Generic',
                    'portion_default' => '1 scoop (30g)',
                    'nutrients' => [
                        'calories' => 120,
                        'protein_g' => 24,
                        'carbs_g' => 3,
                        'fat_g' => 1.5,
                        'fiber_g' => 0,
                        'sugar_g' => 1,
                    ],
                    'description' => 'Whey protein powder for post-workout recovery.',
                ],
            ],
        ];

        return $foods[$categoryName] ?? [];
    }
}
