<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('links', function (Blueprint $table) {
            // Revenue tracking fields
            $table->enum('link_type', ['regular', 'affiliate', 'product', 'sponsored'])
                  ->default('regular')
                  ->after('is_active');
            $table->decimal('commission_rate', 5, 2)->default(0.00)->after('link_type');
            $table->decimal('estimated_value', 10, 2)->default(0.00)->after('commission_rate');
            $table->decimal('sponsored_rate', 10, 2)->default(0.00)->after('estimated_value');
            $table->string('affiliate_program')->nullable()->after('sponsored_rate');
            $table->string('affiliate_tag')->nullable()->after('affiliate_program');
            $table->integer('conversions')->default(0)->after('clicks');
            $table->decimal('total_revenue', 12, 2)->default(0.00)->after('conversions');
        });
    }

    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn([
                'link_type', 'commission_rate', 'estimated_value', 'sponsored_rate',
                'affiliate_program', 'affiliate_tag', 'conversions', 'total_revenue'
            ]);
        });
    }
};