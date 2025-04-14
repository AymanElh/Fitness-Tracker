<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::first();
        $adminId = $adminUser->id ?? null;

        $strengthExercises = [
            [
                'name' => 'Barbell Bench Press',
                'description' => "1. Lie flat on your back on a bench.\n2. Grip the barbell with hands slightly wider than shoulder-width apart.\n3. Lower the bar to your mid-chest.\n4. Press the bar up until your arms are fully extended.\n5. Repeat for desired reps.",
                'type' => 'strength',
                'muscle_group' => 'chest',
                'equipment' => 'Barbell, Bench',
                'difficulty' => 'intermediate',
                'duration' => 20,
                'calories_burned' => 150,
                'image_url' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=rT7DgCr-3pg',
            ],
            [
                'name' => 'Squat',
                'description' => "1. Stand with your feet shoulder-width apart.\n2. Lower your body by bending your knees and hips, as if sitting in a chair.\n3. Keep your chest up and back straight.\n4. Lower until your thighs are parallel to the ground.\n5. Push through your heels to return to the starting position.",
                'type' => 'strength',
                'muscle_group' => 'legs',
                'equipment' => 'Barbell (optional)',
                'difficulty' => 'intermediate',
                'duration' => 20,
                'calories_burned' => 200,
                'image_url' => 'https://images.unsplash.com/photo-1598971639058-d83c236d88fc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=776&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=ultWZbUMPL8',
            ],
            [
                'name' => 'Deadlift',
                'description' => "1. Stand with feet hip-width apart, barbell over mid-foot.\n2. Bend at the hips and knees to grip the bar.\n3. Keep your back straight, chest up.\n4. Push through your heels and stand up with the weight.\n5. Return the weight to the ground with controlled movement.",
                'type' => 'strength',
                'muscle_group' => 'back',
                'equipment' => 'Barbell',
                'difficulty' => 'advanced',
                'duration' => 25,
                'calories_burned' => 250,
                'image_url' => 'https://images.unsplash.com/photo-1599058917212-d750089bc07e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1769&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=op9kVnSso6Q',
            ],
            [
                'name' => 'Dumbbell Shoulder Press',
                'description' => "1. Sit on a bench with back support.\n2. Hold dumbbells at shoulder height with palms facing forward.\n3. Press the weights up until your arms are fully extended.\n4. Lower the weights back to shoulder level.\n5. Repeat for desired reps.",
                'type' => 'strength',
                'muscle_group' => 'shoulders',
                'equipment' => 'Dumbbells, Bench',
                'difficulty' => 'intermediate',
                'duration' => 15,
                'calories_burned' => 120,
                'image_url' => 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1769&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=qEwKCR5JCog',
            ],
            [
                'name' => 'Pull-Up',
                'description' => "1. Hang from a pull-up bar with hands slightly wider than shoulder-width apart.\n2. Pull yourself up until your chin is over the bar.\n3. Lower yourself back down with control.\n4. Repeat for desired reps.",
                'type' => 'strength',
                'muscle_group' => 'back',
                'equipment' => 'Pull-up bar',
                'difficulty' => 'advanced',
                'duration' => 15,
                'calories_burned' => 100,
                'image_url' => 'https://images.unsplash.com/photo-1598266663439-2056e6900339?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=eGo4IYlbE5g',
            ],
        ];

        // Cardio Exercises
        $cardioExercises = [
            [
                'name' => 'Running',
                'description' => "1. Start with a light warm-up jog for 5 minutes.\n2. Increase your pace to a moderate or fast run.\n3. Maintain proper form: shoulders relaxed, core engaged, arms swinging naturally.\n4. Cool down with a 5-minute slow jog or walk.",
                'type' => 'cardio',
                'muscle_group' => 'full_body',
                'equipment' => 'Running shoes',
                'difficulty' => 'intermediate',
                'duration' => 30,
                'calories_burned' => 300,
                'image_url' => 'https://images.unsplash.com/photo-1571008887538-b36bb32f4571?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=_kGESn8ArrU',
            ],
            [
                'name' => 'Cycling',
                'description' => "1. Adjust your bike to the proper height.\n2. Warm up with a slow pedal for 5 minutes.\n3. Increase to moderate intensity for the main session.\n4. Focus on maintaining a consistent cadence.\n5. Cool down for 5 minutes at the end.",
                'type' => 'cardio',
                'muscle_group' => 'legs',
                'equipment' => 'Bicycle or stationary bike',
                'difficulty' => 'beginner',
                'duration' => 45,
                'calories_burned' => 400,
                'image_url' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=ZRl3QLZ1-nE',
            ],
            [
                'name' => 'Jump Rope',
                'description' => "1. Hold the rope handles with a relaxed grip.\n2. Keep elbows close to your sides and rotate from the wrists.\n3. Jump just high enough to clear the rope, about 1-2 inches off the ground.\n4. Land softly on the balls of your feet.\n5. Start with short intervals and build up time.",
                'type' => 'cardio',
                'muscle_group' => 'full_body',
                'equipment' => 'Jump rope',
                'difficulty' => 'intermediate',
                'duration' => 20,
                'calories_burned' => 200,
                'image_url' => 'https://images.unsplash.com/photo-1595365691689-3bbc67779b5c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=u3zgHI8QnqE',
            ],
        ];

        // Flexibility Exercises
        $flexibilityExercises = [
            [
                'name' => 'Hamstring Stretch',
                'description' => "1. Sit on the floor with one leg extended and the other bent.\n2. Reach toward your toes of the extended leg.\n3. Hold the stretch for 20-30 seconds.\n4. Repeat on the other side.",
                'type' => 'flexibility',
                'muscle_group' => 'legs',
                'equipment' => 'None',
                'difficulty' => 'beginner',
                'duration' => 10,
                'calories_burned' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1597452485669-2c7bb5fef90d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1771&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=FDwpEdxZ4H4',
            ],
            [
                'name' => 'Cobra Pose',
                'description' => "1. Lie face down with palms on the floor under your shoulders.\n2. Press into your hands and lift your chest off the floor.\n3. Keep your lower body relaxed on the floor.\n4. Hold for 15-30 seconds, breathing deeply.\n5. Release back down slowly.",
                'type' => 'flexibility',
                'muscle_group' => 'back',
                'equipment' => 'Yoga mat',
                'difficulty' => 'beginner',
                'duration' => 5,
                'calories_burned' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1510894347713-fc3ed6fdf539?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=zgvolE4NAH0',
            ],
        ];

        // Balance Exercises
        $balanceExercises = [
            [
                'name' => 'Single Leg Stand',
                'description' => "1. Stand with feet together and arms at your sides.\n2. Shift your weight to one foot and lift the other foot off the ground.\n3. Hold the position for 30 seconds.\n4. Switch to the other foot and repeat.",
                'type' => 'balance',
                'muscle_group' => 'core',
                'equipment' => 'None',
                'difficulty' => 'beginner',
                'duration' => 5,
                'calories_burned' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1507398941-efe050c89ad8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=jgh6Zfk5IQY',
            ],
            [
                'name' => 'Bosu Ball Squat',
                'description' => "1. Stand on the flat side of a Bosu ball with feet shoulder-width apart.\n2. Slowly lower into a squat position.\n3. Hold for a moment at the bottom.\n4. Push through your heels to return to standing.\n5. Repeat for desired reps.",
                'type' => 'balance',
                'muscle_group' => 'legs',
                'equipment' => 'Bosu Ball',
                'difficulty' => 'intermediate',
                'duration' => 15,
                'calories_burned' => 100,
                'image_url' => 'https://images.unsplash.com/photo-1591117207239-788bf8de6c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=swLim3YQ1WE',
            ],
        ];

        // Plyometric Exercises
        $plyometricExercises = [
            [
                'name' => 'Box Jumps',
                'description' => "1. Stand facing a sturdy box or platform.\n2. Bend your knees and swing your arms back.\n3. Explosively jump onto the box, landing softly with bent knees.\n4. Step back down and repeat.",
                'type' => 'plyometric',
                'muscle_group' => 'legs',
                'equipment' => 'Plyo box',
                'difficulty' => 'advanced',
                'duration' => 15,
                'calories_burned' => 150,
                'image_url' => 'https://images.unsplash.com/photo-1597586594276-243245ffdfd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2940&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=52r_Ul5k03g',
            ],
            [
                'name' => 'Burpees',
                'description' => "1. Start in a standing position.\n2. Drop into a squat position and place hands on the ground.\n3. Kick feet back into a plank position.\n4. Perform a push-up (optional).\n5. Jump feet back to squat position.\n6. Explode upward with a jump and reach arms overhead.",
                'type' => 'plyometric',
                'muscle_group' => 'full_body',
                'equipment' => 'None',
                'difficulty' => 'advanced',
                'duration' => 20,
                'calories_burned' => 250,
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=TU8QYVW0gDU',
            ],
        ];

        // Functional Exercises
        $functionalExercises = [
            [
                'name' => 'Kettlebell Swing',
                'description' => "1. Stand with feet shoulder-width apart, holding a kettlebell with both hands.\n2. Hinge at the hips and swing the kettlebell between your legs.\n3. Thrust your hips forward to swing the kettlebell up to chest height.\n4. Let the kettlebell naturally swing back down between your legs.\n5. Repeat in a continuous motion.",
                'type' => 'functional',
                'muscle_group' => 'full_body',
                'equipment' => 'Kettlebell',
                'difficulty' => 'intermediate',
                'duration' => 15,
                'calories_burned' => 200,
                'image_url' => 'https://images.unsplash.com/photo-1517344800994-80b20463999c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=mKDIuUbH3nk',
            ],
            [
                'name' => 'Farmer\'s Walk',
                'description' => "1. Hold a heavy weight in each hand at your sides.\n2. Stand tall with shoulders back and core engaged.\n3. Walk forward with controlled steps for a set distance or time.\n4. Set the weights down with control.",
                'type' => 'functional',
                'muscle_group' => 'full_body',
                'equipment' => 'Dumbbells or Kettlebells',
                'difficulty' => 'beginner',
                'duration' => 10,
                'calories_burned' => 120,
                'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80',
                'video_url' => 'https://www.youtube.com/watch?v=rt17lmnaLSM',
            ],
        ];

        // Combine all exercise categories
        $allExercises = array_merge(
            $strengthExercises,
            $cardioExercises,
            $flexibilityExercises,
            $balanceExercises,
            $plyometricExercises,
            $functionalExercises
        );

        // Add created_by to all exercises
        foreach ($allExercises as $exercise) {
            $exercise['created_by'] = $adminId;
            Exercise::create($exercise);
        }
        $this->command->info('Exercise seeder completed successfully! Added ' . count($allExercises) . ' exercises.');
    }
}
