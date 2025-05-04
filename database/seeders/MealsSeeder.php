<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\MealItem;
use App\Models\User;
use App\Models\Food;
use Illuminate\Database\Seeder;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Get the user to associate with created meals
        $user = User::find(1);

        // Check if we have food items to use
        $foodCount = Food::count();
        if ($foodCount === 0) {
            $this->command->info('No food items found. Please run FoodItemsTableSeeder first.');
            return;
        }

        // Breakfast Meals
        $this->createBreakfastMeals($user->id);

        // Lunch Meals
        $this->createLunchMeals($user->id);

        // Dinner Meals
        $this->createDinnerMeals($user->id);

        // Snack Meals
        $this->createSnackMeals($user->id);

        $this->command->info('Meals and meal items created successfully!');
    }

    /**
     * Create breakfast meals
     */
    private function createBreakfastMeals($userId): void
    {
        // Meal 1: Avocado Toast with Egg
        $meal = Meal::create([
            'name' => 'Avocado Toast with Egg',
            'description' => 'Whole grain toast topped with mashed avocado, a poached egg, and a sprinkle of red pepper flakes.',
            'image_url' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'breakfast',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Whole Grain Bread', 'quantity' => 2, 'unit' => 'slice'],
            ['name' => 'Avocado', 'quantity' => 0.5, 'unit' => 'whole'],
            ['name' => 'Egg', 'quantity' => 1, 'unit' => 'large'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tsp'],
            ['name' => 'Red Pepper Flakes', 'quantity' => 0.25, 'unit' => 'tsp'],
        ]);

        // Meal 2: Greek Yogurt with Berries and Honey
        $meal = Meal::create([
            'name' => 'Greek Yogurt with Berries and Honey',
            'description' => 'Creamy Greek yogurt topped with fresh mixed berries and a drizzle of honey.',
            'image_url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'breakfast',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Greek Yogurt', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Strawberries', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Blueberries', 'quantity' => 0.25, 'unit' => 'cup'],
            ['name' => 'Honey', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Almonds', 'quantity' => 1, 'unit' => 'tbsp'],
        ]);

        // Meal 3: Oatmeal with Fruits and Nuts
        $meal = Meal::create([
            'name' => 'Oatmeal with Fruits and Nuts',
            'description' => 'Hearty oatmeal cooked with milk, topped with fresh fruits, nuts, and a touch of cinnamon.',
            'image_url' => 'https://images.unsplash.com/photo-1517673132405-a56a62b18caf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'breakfast',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Rolled Oats', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Almond Milk', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Banana', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Walnuts', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Cinnamon', 'quantity' => 0.25, 'unit' => 'tsp'],
            ['name' => 'Maple Syrup', 'quantity' => 1, 'unit' => 'tsp'],
        ]);

        // Meal 4: Protein Smoothie Bowl
        $meal = Meal::create([
            'name' => 'Protein Smoothie Bowl',
            'description' => 'Thick smoothie made with protein powder, banana, and berries, topped with granola and seeds.',
            'image_url' => 'https://images.unsplash.com/photo-1511690078903-71dc5a49f5e3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'breakfast',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Banana', 'quantity' => 1, 'unit' => 'medium'],
            ['name' => 'Whey Protein Powder', 'quantity' => 1, 'unit' => 'scoop'],
            ['name' => 'Almond Milk', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Mixed Berries', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Granola', 'quantity' => 2, 'unit' => 'tbsp'],
            ['name' => 'Chia Seeds', 'quantity' => 1, 'unit' => 'tsp'],
        ]);

        // Meal 5: Vegetable Omelette
        $meal = Meal::create([
            'name' => 'Vegetable Omelette',
            'description' => 'Fluffy omelette filled with sautéed vegetables and a sprinkle of cheese.',
            'image_url' => 'https://images.unsplash.com/photo-1510693206972-df098062cb71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'breakfast',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Eggs', 'quantity' => 2, 'unit' => 'large'],
            ['name' => 'Bell Pepper', 'quantity' => 0.25, 'unit' => 'medium'],
            ['name' => 'Onion', 'quantity' => 0.25, 'unit' => 'medium'],
            ['name' => 'Spinach', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Cheddar Cheese', 'quantity' => 0.25, 'unit' => 'cup'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tsp'],
        ]);
    }

    /**
     * Create lunch meals
     */
    private function createLunchMeals($userId): void
    {
        // Meal 1: Grilled Chicken Salad
        $meal = Meal::create([
            'name' => 'Grilled Chicken Salad',
            'description' => 'Fresh mixed greens topped with grilled chicken breast, cherry tomatoes, cucumber, and balsamic vinaigrette.',
            'image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'lunch',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Chicken Breast', 'quantity' => 4, 'unit' => 'oz'],
            ['name' => 'Mixed Greens', 'quantity' => 2, 'unit' => 'cups'],
            ['name' => 'Cherry Tomatoes', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Cucumber', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Balsamic Vinaigrette', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tsp'],
        ]);

        // Meal 2: Quinoa Bowl with Vegetables
        $meal = Meal::create([
            'name' => 'Quinoa Bowl with Vegetables',
            'description' => 'Protein-rich quinoa bowl with roasted vegetables, chickpeas, and tahini dressing.',
            'image_url' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'lunch',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Quinoa', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Sweet Potato', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Chickpeas', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Broccoli', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Red Bell Pepper', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Tahini', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Lemon Juice', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tsp'],
        ]);

        // Meal 3: Turkey and Avocado Wrap
        $meal = Meal::create([
            'name' => 'Turkey and Avocado Wrap',
            'description' => 'Whole grain wrap filled with sliced turkey, avocado, lettuce, tomato, and light mayo.',
            'image_url' => 'https://images.unsplash.com/photo-1521986329282-0436c1f1e212?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'lunch',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Whole Grain Wrap', 'quantity' => 1, 'unit' => 'large'],
            ['name' => 'Turkey Breast', 'quantity' => 3, 'unit' => 'oz'],
            ['name' => 'Avocado', 'quantity' => 0.25, 'unit' => 'medium'],
            ['name' => 'Lettuce', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Tomato', 'quantity' => 0.25, 'unit' => 'medium'],
            ['name' => 'Light Mayonnaise', 'quantity' => 1, 'unit' => 'tsp'],
            ['name' => 'Mustard', 'quantity' => 1, 'unit' => 'tsp'],
        ]);

        // Meal 4: Tuna Salad Sandwich
        $meal = Meal::create([
            'name' => 'Tuna Salad Sandwich',
            'description' => 'Classic tuna salad made with light mayo and diced vegetables, served on whole grain bread.',
            'image_url' => 'https://images.unsplash.com/photo-1550507992-eb63ffee0847?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'lunch',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Tuna (canned in water)', 'quantity' => 3, 'unit' => 'oz'],
            ['name' => 'Whole Grain Bread', 'quantity' => 2, 'unit' => 'slices'],
            ['name' => 'Light Mayonnaise', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Celery', 'quantity' => 1, 'unit' => 'stalk'],
            ['name' => 'Red Onion', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Lettuce', 'quantity' => 0.25, 'unit' => 'cup'],
        ]);

        // Meal 5: Mediterranean Pasta Salad
        $meal = Meal::create([
            'name' => 'Mediterranean Pasta Salad',
            'description' => 'Whole wheat pasta mixed with olives, feta cheese, tomatoes, cucumber, and a lemon herb dressing.',
            'image_url' => 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'lunch',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Whole Wheat Pasta', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Cherry Tomatoes', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Cucumber', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Kalamata Olives', 'quantity' => 0.25, 'unit' => 'cup'],
            ['name' => 'Feta Cheese', 'quantity' => 0.25, 'unit' => 'cup'],
            ['name' => 'Red Onion', 'quantity' => 0.25, 'unit' => 'small'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Lemon Juice', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Oregano', 'quantity' => 0.5, 'unit' => 'tsp'],
        ]);
    }

    /**
     * Create dinner meals
     */
    private function createDinnerMeals($userId): void
    {
        // Meal 1: Baked Salmon with Asparagus
        $meal = Meal::create([
            'name' => 'Baked Salmon with Asparagus',
            'description' => 'Oven-baked salmon fillet with garlic and herb seasoning, served with roasted asparagus.',
            'image_url' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'dinner',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Salmon Fillet', 'quantity' => 5, 'unit' => 'oz'],
            ['name' => 'Asparagus', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Garlic', 'quantity' => 1, 'unit' => 'clove'],
            ['name' => 'Lemon', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Dill', 'quantity' => 0.5, 'unit' => 'tsp'],
        ]);

        // Meal 2: Grilled Steak with Roasted Vegetables
        $meal = Meal::create([
            'name' => 'Grilled Steak with Roasted Vegetables',
            'description' => 'Lean grilled steak served with a colorful mix of roasted seasonal vegetables.',
            'image_url' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'dinner',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Lean Beef Steak', 'quantity' => 6, 'unit' => 'oz'],
            ['name' => 'Bell Peppers', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Zucchini', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Red Onion', 'quantity' => 0.25, 'unit' => 'medium'],
            ['name' => 'Carrots', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Garlic Powder', 'quantity' => 0.25, 'unit' => 'tsp'],
            ['name' => 'Rosemary', 'quantity' => 0.5, 'unit' => 'tsp'],
        ]);

        // Meal 3: Vegetable Stir-fry with Tofu
        $meal = Meal::create([
            'name' => 'Vegetable Stir-fry with Tofu',
            'description' => 'Asian-inspired stir-fry with crispy tofu, mixed vegetables, and a savory sauce, served over brown rice.',
            'image_url' => 'https://images.unsplash.com/photo-1512003867696-6d5ce6835040?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'dinner',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Firm Tofu', 'quantity' => 4, 'unit' => 'oz'],
            ['name' => 'Brown Rice', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Broccoli', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Carrots', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Snow Peas', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Bell Pepper', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Soy Sauce', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Sesame Oil', 'quantity' => 1, 'unit' => 'tsp'],
            ['name' => 'Ginger', 'quantity' => 0.5, 'unit' => 'tsp'],
            ['name' => 'Garlic', 'quantity' => 1, 'unit' => 'clove'],
        ]);

        // Meal 4: Chicken and Vegetable Curry
        $meal = Meal::create([
            'name' => 'Chicken and Vegetable Curry',
            'description' => 'Fragrant curry with tender chicken pieces, mixed vegetables, and coconut milk, served with brown rice.',
            'image_url' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'dinner',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Chicken Breast', 'quantity' => 4, 'unit' => 'oz'],
            ['name' => 'Brown Rice', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Coconut Milk', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Curry Powder', 'quantity' => 1, 'unit' => 'tsp'],
            ['name' => 'Cauliflower', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Sweet Potato', 'quantity' => 0.5, 'unit' => 'small'],
            ['name' => 'Spinach', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Onion', 'quantity' => 0.25, 'unit' => 'medium'],
            ['name' => 'Garlic', 'quantity' => 1, 'unit' => 'clove'],
            ['name' => 'Ginger', 'quantity' => 0.5, 'unit' => 'tsp'],
        ]);

        // Meal 5: Lentil and Vegetable Soup
        $meal = Meal::create([
            'name' => 'Lentil and Vegetable Soup',
            'description' => 'Hearty soup made with protein-rich lentils, mixed vegetables, and aromatic herbs.',
            'image_url' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'dinner',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Lentils', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Carrots', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Celery', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Onion', 'quantity' => 0.25, 'unit' => 'medium'],
            ['name' => 'Tomatoes', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Vegetable Broth', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Spinach', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Garlic', 'quantity' => 1, 'unit' => 'clove'],
            ['name' => 'Cumin', 'quantity' => 0.5, 'unit' => 'tsp'],
            ['name' => 'Thyme', 'quantity' => 0.25, 'unit' => 'tsp'],
            ['name' => 'Olive Oil', 'quantity' => 1, 'unit' => 'tsp'],
        ]);
    }

    /**
     * Create snack meals
     */
    private function createSnackMeals($userId): void
    {
        // Meal 1: Protein Smoothie
        $meal = Meal::create([
            'name' => 'Protein Smoothie',
            'description' => 'Refreshing smoothie with whey protein, banana, berries, and almond milk.',
            'image_url' => 'https://images.unsplash.com/photo-1505252585461-04db1eb84625?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'snack',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Whey Protein Powder', 'quantity' => 1, 'unit' => 'scoop'],
            ['name' => 'Banana', 'quantity' => 0.5, 'unit' => 'medium'],
            ['name' => 'Mixed Berries', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Almond Milk', 'quantity' => 1, 'unit' => 'cup'],
            ['name' => 'Ice', 'quantity' => 0.5, 'unit' => 'cup'],
        ]);

        // Meal 2: Mixed Nuts and Dried Fruits
        $meal = Meal::create([
            'name' => 'Mixed Nuts and Dried Fruits',
            'description' => 'Energy-boosting mix of various nuts and dried fruits.',
            'image_url' => 'https://images.unsplash.com/photo-1604049629814-23c186a8eb87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'snack',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Almonds', 'quantity' => 0.25, 'unit' => 'cup'],
            ['name' => 'Walnuts', 'quantity' => 0.25, 'unit' => 'cup'],
            ['name' => 'Dried Cranberries', 'quantity' => 2, 'unit' => 'tbsp'],
            ['name' => 'Dried Apricots', 'quantity' => 2, 'unit' => 'pieces'],
            ['name' => 'Pumpkin Seeds', 'quantity' => 1, 'unit' => 'tbsp'],
        ]);

        // Meal 3: Hummus with Vegetable Sticks
        $meal = Meal::create([
            'name' => 'Hummus with Vegetable Sticks',
            'description' => 'Creamy hummus served with fresh, crunchy vegetable sticks for dipping.',
            'image_url' => 'https://images.unsplash.com/photo-1540914124281-342587941389?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'snack',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Hummus', 'quantity' => 0.25, 'unit' => 'cup'],
            ['name' => 'Carrot Sticks', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Celery Sticks', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Bell Pepper Strips', 'quantity' => 0.5, 'unit' => 'cup'],
            ['name' => 'Cucumber Slices', 'quantity' => 0.5, 'unit' => 'cup'],
        ]);

        // Meal 4: Greek Yogurt with Honey
        $meal = Meal::create([
            'name' => 'Greek Yogurt with Honey',
            'description' => 'High-protein Greek yogurt sweetened with a touch of honey.',
            'image_url' => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'snack',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Greek Yogurt', 'quantity' => 0.75, 'unit' => 'cup'],
            ['name' => 'Honey', 'quantity' => 1, 'unit' => 'tsp'],
            ['name' => 'Cinnamon', 'quantity' => 0.25, 'unit' => 'tsp'],
        ]);

        // Meal 5: Apple with Almond Butter
        $meal = Meal::create([
            'name' => 'Apple with Almond Butter',
            'description' => 'Fresh apple slices served with creamy almond butter for a balanced snack.',
            'image_url' => 'https://images.unsplash.com/photo-1607306353048-9d882a9a6c7c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'type' => 'snack',
            'created_by' => $userId,
        ]);

        $this->addMealItems($meal, [
            ['name' => 'Apple', 'quantity' => 1, 'unit' => 'medium'],
            ['name' => 'Almond Butter', 'quantity' => 1, 'unit' => 'tbsp'],
        ]);
    }

    /**
     * Add items to a meal by finding or creating food items
     */
    private function addMealItems($meal, $items): void
    {
        foreach ($items as $item) {

            $food = Food::where('name', 'like', $item['name'])->first();

            // If no matching food exists, try to find a similar one
            if (!$food) {
                $food = Food::where('name', 'like', '%' . explode(' ', $item['name'])[0] . '%')->first();
            }

            // If still no match, use the first available food
            if (!$food) {
                $food = Food::first();
            }
            if ($food) {
                // Calculate rough nutrients based on quantity
                $nutrients = [
                    'calories' => $food->calories * $item['quantity'],
                    'protein' => $food->protein * $item['quantity'],
                    'carbs' => $food->carbs * $item['quantity'],
                    'fat' => $food->fat * $item['quantity'],
                ];

//                dd($nutrients);

                MealItem::create([
                    'meal_id' => $meal->id,
                    'food_id' => $food->id,
                    'quantity' => $item['quantity'],
                    'quantity_unit' => $item['unit'] ?? 'serving',
                    'nutrients' => json_encode($nutrients),
                ]);
            }
        }
    }
}
