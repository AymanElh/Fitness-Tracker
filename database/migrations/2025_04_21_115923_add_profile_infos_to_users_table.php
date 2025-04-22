<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('email');
            $table->float('weight')->nullable()->after('bio');
            $table->float('height')->nullable()->after('weight');
            $table->date('date_of_birth')->nullable()->after('height');
            $table->string('gender')->nullable()->after('date_of_birth');
            $table->string('profile_photo_path')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio', 'weight', 'height', 'date_of_birth', 'gender', 'profile_photo_path']);
        });
    }
};
