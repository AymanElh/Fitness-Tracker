<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\MealItem;
use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Creating meals...');

        // Get user
        $user = User::find(1);

        // Create breakfast meals
        $this->createBreakfastMeals($user->id);

        // Create lunch meals
        $this->createLunchMeals($user->id);

        // Create dinner meals
        $this->createDinnerMeals($user->id);

        // Create snack meals
        $this->createSnackMeals($user->id);

        $this->command->info('Meals seeded successfully!');
    }

    /**
     * Create breakfast meals
     */
    private function createBreakfastMeals($userId)
    {
        $this->command->info('Creating breakfast meals...');

        // Oatmeal with Fruits and Nuts
        $meal = $this->createMeal([
            'name' => 'Oatmeal with Fruits and Nuts',
            'description' => 'Hearty oatmeal topped with fresh fruits and nuts for a nutrient-dense breakfast.',
            'type' => 'breakfast',
            'image_url' => 'https://images.unsplash.com/photo-1517673132405-a56a62b18caf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Oats', 1, 'cup dry');
        $this->addFoodToMeal($meal, 'Banana', 1, 'medium');
        $this->addFoodToMeal($meal, 'Blueberries', 0.5, 'cup');
        $this->addFoodToMeal($meal, 'Almonds', 0.25, 'oz');
        $this->addFoodToMeal($meal, 'Almond Milk (Unsweetened)', 1, 'cup');

        // Greek Yogurt Parfait
        $meal = $this->createMeal([
            'name' => 'Greek Yogurt Parfait',
            'description' => 'Protein-rich Greek yogurt layered with fresh berries and crunchy granola.',
            'type' => 'breakfast',
            'image_url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Greek Yogurt (Plain, Nonfat)', 1, 'cup');
        $this->addFoodToMeal($meal, 'Strawberries', 0.5, 'cup');
        $this->addFoodToMeal($meal, 'Blueberries', 0.25, 'cup');
        $this->addFoodToMeal($meal, 'Almonds', 0.5, 'oz');

        // Avocado Toast with Egg
        $meal = $this->createMeal([
            'name' => 'Avocado Toast with Egg',
            'description' => 'Whole grain toast topped with mashed avocado and a poached egg.',
            'type' => 'breakfast',
            'image_url' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Whole Wheat Bread', 2, 'slice');
        $this->addFoodToMeal($meal, 'Avocado', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Eggs', 1, 'large');

        // Breakfast Smoothie Bowl
        $meal = $this->createMeal([
            'name' => 'Protein Smoothie Bowl',
            'description' => 'Thick, protein-packed smoothie topped with fruits and granola.',
            'type' => 'breakfast',
            'image_url' => 'https://images.unsplash.com/photo-1511690078903-71dc5a49f5e3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Banana', 1, 'medium');
        $this->addFoodToMeal($meal, 'Protein Shake', 1, 'scoop');
        $this->addFoodToMeal($meal, 'Almond Milk (Unsweetened)', 1, 'cup');
        $this->addFoodToMeal($meal, 'Strawberries', 0.5, 'cup');
        $this->addFoodToMeal($meal, 'Blueberries', 0.25, 'cup');
    }

    /**
     * Create lunch meals
     */
    private function createLunchMeals($userId)
    {
        $this->command->info('Creating lunch meals...');

        // Chicken Salad
        $meal = $this->createMeal([
            'name' => 'Grilled Chicken Salad',
            'description' => 'Lean grilled chicken breast served over fresh mixed greens with colorful vegetables.',
            'type' => 'lunch',
            'image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Chicken Breast', 3, 'oz');
        $this->addFoodToMeal($meal, 'Spinach', 2, 'cup');
        $this->addFoodToMeal($meal, 'Bell Pepper (Red)', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Carrots', 1, 'medium');
        $this->addFoodToMeal($meal, 'Avocado', 0.25, 'medium');

        // Quinoa Bowl
        $meal = $this->createMeal([
            'name' => 'Quinoa Vegetable Bowl',
            'description' => 'Protein-rich quinoa with roasted vegetables and avocado.',
            'type' => 'lunch',
            'image_url' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Quinoa', 0.5, 'cup dry');
        $this->addFoodToMeal($meal, 'Sweet Potato', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Broccoli', 1, 'cup chopped');
        $this->addFoodToMeal($meal, 'Bell Pepper (Red)', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Avocado', 0.25, 'medium');

        // Salmon with Vegetables
        $meal = $this->createMeal([
            'name' => 'Salmon with Roasted Vegetables',
            'description' => 'Omega-3 rich salmon fillet served with a colorful mix of roasted vegetables.',
            'type' => 'lunch',
            'image_url' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Salmon', 4, 'oz');
        $this->addFoodToMeal($meal, 'Broccoli', 1, 'cup chopped');
        $this->addFoodToMeal($meal, 'Sweet Potato', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Bell Pepper (Red)', 0.5, 'medium');

        // Mediterranean Wrap
        $meal = $this->createMeal([
            'name' => 'Mediterranean Hummus Wrap',
            'description' => 'Whole grain wrap filled with hummus, fresh vegetables, and feta cheese.',
            'type' => 'lunch',
            'image_url' => 'https://images.unsplash.com/photo-1521986329282-0436c1f1e212?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Whole Wheat Bread', 2, 'slice');
        $this->addFoodToMeal($meal, 'Hummus', 4, 'tbsp');
        $this->addFoodToMeal($meal, 'Bell Pepper (Red)', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Spinach', 1, 'cup');
        $this->addFoodToMeal($meal, 'Carrots', 0.5, 'medium');
    }

    /**
     * Create dinner meals
     */
    private function createDinnerMeals($userId)
    {
        $this->command->info('Creating dinner meals...');

        // Baked Salmon Dinner
        $meal = $this->createMeal([
            'name' => 'Baked Salmon with Sweet Potato',
            'description' => 'Oven-baked salmon fillet served with roasted sweet potato and steamed vegetables.',
            'type' => 'dinner',
            'image_url' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Salmon', 5, 'oz');
        $this->addFoodToMeal($meal, 'Sweet Potato', 1, 'medium');
        $this->addFoodToMeal($meal, 'Broccoli', 1.5, 'cup chopped');
        $this->addFoodToMeal($meal, 'Quinoa', 0.25, 'cup dry');

        // Grilled Chicken Dinner
        $meal = $this->createMeal([
            'name' => 'Grilled Chicken with Quinoa',
            'description' => 'Seasoned grilled chicken breast served with fluffy quinoa and roasted vegetables.',
            'type' => 'dinner',
            'image_url' => 'https://images.unsplash.com/photo-1518492104633-130d8bcce2f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Chicken Breast', 6, 'oz');
        $this->addFoodToMeal($meal, 'Quinoa', 0.5, 'cup dry');
        $this->addFoodToMeal($meal, 'Bell Pepper (Red)', 1, 'medium');
        $this->addFoodToMeal($meal, 'Broccoli', 1, 'cup chopped');

        // Vegetarian Stir Fry
        $meal = $this->createMeal([
            'name' => 'Tofu Vegetable Stir Fry',
            'description' => 'Protein-rich tofu stir-fried with mixed vegetables and served over brown rice.',
            'type' => 'dinner',
            'image_url' => 'https://images.unsplash.com/photo-1512003867696-6d5ce6835040?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Tofu', 6, 'oz');
        $this->addFoodToMeal($meal, 'Brown Rice', 0.5, 'cup dry');
        $this->addFoodToMeal($meal, 'Broccoli', 1, 'cup chopped');
        $this->addFoodToMeal($meal, 'Bell Pepper (Red)', 1, 'medium');
        $this->addFoodToMeal($meal, 'Carrots', 1, 'medium');

        // Protein Bowl
        $meal = $this->createMeal([
            'name' => 'Power Protein Bowl',
            'description' => 'Hearty bowl featuring lean protein, complex carbs, and nutrient-dense vegetables.',
            'type' => 'dinner',
            'image_url' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Chicken Breast', 4, 'oz');
        $this->addFoodToMeal($meal, 'Sweet Potato', 1, 'medium');
        $this->addFoodToMeal($meal, 'Quinoa', 0.25, 'cup dry');
        $this->addFoodToMeal($meal, 'Avocado', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Spinach', 2, 'cup');
    }

    /**
     * Create snack meals
     */
    private function createSnackMeals($userId)
    {
        $this->command->info('Creating snack meals...');

        // Protein Smoothie
        $meal = $this->createMeal([
            'name' => 'Protein Fruit Smoothie',
            'description' => 'Refreshing smoothie with protein powder, banana, berries, and almond milk.',
            'type' => 'snack',
            'image_url' => 'https://images.unsplash.com/photo-1505252585461-04db1eb84625?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Protein Shake', 1, 'scoop');
        $this->addFoodToMeal($meal, 'Banana', 1, 'medium');
        $this->addFoodToMeal($meal, 'Strawberries', 0.5, 'cup');
        $this->addFoodToMeal($meal, 'Almond Milk (Unsweetened)', 1, 'cup');

        // Greek Yogurt with Fruit
        $meal = $this->createMeal([
            'name' => 'Greek Yogurt with Berries',
            'description' => 'Protein-packed Greek yogurt topped with fresh berries.',
            'type' => 'snack',
            'image_url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Greek Yogurt (Plain, Nonfat)', 0.75, 'cup');
        $this->addFoodToMeal($meal, 'Blueberries', 0.5, 'cup');
        $this->addFoodToMeal($meal, 'Strawberries', 0.5, 'cup');

        // Hummus with Veggies
        $meal = $this->createMeal([
            'name' => 'Hummus with Fresh Vegetables',
            'description' => 'Creamy hummus served with crunchy fresh vegetables for dipping.',
            'type' => 'snack',
            'image_url' => 'https://images.unsplash.com/photo-1540914124281-342587941389?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Hummus', 4, 'tbsp');
        $this->addFoodToMeal($meal, 'Bell Pepper (Red)', 0.5, 'medium');
        $this->addFoodToMeal($meal, 'Carrots', 1, 'medium');
        $this->addFoodToMeal($meal, 'Broccoli', 0.5, 'cup chopped');

        // Fruit and Nut Mix
        $meal = $this->createMeal([
            'name' => 'Apple with Almonds',
            'description' => 'Fresh apple slices with a side of almonds for a balanced sweet and savory snack.',
            'type' => 'snack',
            'image_url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'created_by' => $userId,
        ]);

        $this->addFoodToMeal($meal, 'Apple', 1, 'medium');
        $this->addFoodToMeal($meal, 'Almonds', 1, 'oz');
    }

    /**
     * Create a meal record
     */
    private function createMeal($data)
    {
        try {
            return Meal::create($data);
        } catch (\Exception $e) {
            $this->command->error("Error creating meal: {$data['name']}");
            $this->command->error($e->getMessage());
            Log::error("Error creating meal: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add a food item to a meal
     */
    private function addFoodToMeal($meal, $foodName, $quantity, $unit)
    {
        if (!$meal) return;

        try {
            // Find the food by name
            $food = Food::where('name', 'like', "%{$foodName}%")->first();

            if (!$food) {
                $this->command->warn("Food not found: {$foodName}");
                return;
            }

            // Calculate rough nutrients based on quantity ratio
            // We assume the default portion is the reference quantity
            $foodNutrients = $food->nutrients;

            // Create the meal item
            $mealItem = new MealItem([
                'food_id' => $food->id,
                'quantity' => $quantity,
                'quantity_unit' => $unit,
            ]);

            // Calculate nutrients based on quantity
            if (is_array($foodNutrients) || is_object($foodNutrients)) {
                $calculatedNutrients = [];

                // Extract values or use default 0
                $calories = $foodNutrients['calories'] ?? 0;
                $protein = $foodNutrients['protein_g'] ?? 0;
                $carbs = $foodNutrients['carbs_g'] ?? 0;
                $fat = $foodNutrients['fat_g'] ?? 0;

                // Simple scaling by quantity
                $calculatedNutrients = [
                    'calories' => $calories * $quantity,
                    'protein' => $protein * $quantity,
                    'carbs' => $carbs * $quantity,
                    'fat' => $fat * $quantity
                ];

                $mealItem->nutrients = json_encode($calculatedNutrients);
            }

            $meal->items()->save($mealItem);

        } catch (\Exception $e) {
            $this->command->error("Error adding food: {$foodName} to meal: {$meal->name}");
            $this->command->error($e->getMessage());
            Log::error("Error adding food to meal: " . $e->getMessage());
        }
    }
}
