// database/migrations/add_profile_fields_to_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('email');
            $table->string('display_name')->nullable()->after('username');
            $table->text('bio')->nullable()->after('display_name');
            $table->string('profile_image')->nullable()->after('bio');
            $table->string('theme_color')->default('#3B82F6')->after('profile_image');
            $table->boolean('is_active')->default(true)->after('theme_color');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 'display_name', 'bio', 
                'profile_image', 'theme_color', 'is_active'
            ]);
        });
    }
};