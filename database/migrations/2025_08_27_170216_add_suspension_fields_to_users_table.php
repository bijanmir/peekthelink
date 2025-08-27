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
            $table->boolean('is_suspended')->default(false)->after('is_admin');
            $table->timestamp('suspended_at')->nullable()->after('is_suspended');
            $table->string('suspended_reason')->nullable()->after('suspended_at');
            $table->text('admin_notes')->nullable()->after('suspended_reason');
            $table->timestamp('last_login_at')->nullable()->after('admin_notes');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_suspended',
                'suspended_at', 
                'suspended_reason',
                'admin_notes',
                'last_login_at',
                'last_login_ip'
            ]);
        });
    }
};
