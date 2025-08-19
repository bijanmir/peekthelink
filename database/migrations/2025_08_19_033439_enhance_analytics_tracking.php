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
        Schema::table('link_clicks', function (Blueprint $table) {
            // Geographic data
            $table->string('country_code', 2)->nullable()->after('referer');
            $table->string('country_name')->nullable()->after('country_code');
            $table->string('region')->nullable()->after('country_name');
            $table->string('city')->nullable()->after('region');
            $table->decimal('latitude', 10, 8)->nullable()->after('city');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            
            // Enhanced device/browser data
            $table->string('device_type')->nullable()->after('user_agent'); // mobile, desktop, tablet
            $table->string('browser_name')->nullable()->after('device_type');
            $table->string('browser_version')->nullable()->after('browser_name');
            $table->string('operating_system')->nullable()->after('browser_version');
            $table->string('screen_resolution')->nullable()->after('operating_system');
            
            // Traffic source analysis
            $table->string('traffic_source')->nullable()->after('referer'); // direct, social, search, referral, campaign
            $table->string('utm_source')->nullable()->after('traffic_source');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('utm_term')->nullable()->after('utm_campaign');
            $table->string('utm_content')->nullable()->after('utm_term');
            
            // Session tracking
            $table->string('session_id')->nullable()->after('utm_content');
            $table->boolean('is_unique_visitor')->default(false)->after('session_id');
            $table->integer('session_duration')->nullable()->after('is_unique_visitor'); // seconds on page
            
            // Advanced metrics
            $table->boolean('is_bot')->default(false)->after('session_duration');
            $table->string('language')->nullable()->after('is_bot');
            $table->string('timezone')->nullable()->after('language');
            
            // Add indexes for better performance
            $table->index(['country_code', 'created_at']);
            $table->index(['traffic_source', 'created_at']);
            $table->index(['device_type', 'created_at']);
            $table->index(['session_id']);
            $table->index(['is_unique_visitor', 'created_at']);
        });
        
        // Create a separate table for page views (profile visits)
        Schema::create('profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address');
            $table->text('user_agent');
            $table->string('referer')->nullable();
            
            // Geographic data
            $table->string('country_code', 2)->nullable();
            $table->string('country_name')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Device/browser data
            $table->string('device_type')->nullable();
            $table->string('browser_name')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('screen_resolution')->nullable();
            
            // Traffic source
            $table->string('traffic_source')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_content')->nullable();
            
            // Session data
            $table->string('session_id')->nullable();
            $table->boolean('is_unique_visitor')->default(false);
            $table->integer('session_duration')->nullable();
            $table->boolean('is_bot')->default(false);
            $table->string('language')->nullable();
            $table->string('timezone')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'created_at']);
            $table->index(['country_code', 'created_at']);
            $table->index(['traffic_source', 'created_at']);
            $table->index(['device_type', 'created_at']);
            $table->index(['session_id']);
            $table->index(['is_unique_visitor', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_views');
        
        Schema::table('link_clicks', function (Blueprint $table) {
            $table->dropIndex(['country_code', 'created_at']);
            $table->dropIndex(['traffic_source', 'created_at']);
            $table->dropIndex(['device_type', 'created_at']);
            $table->dropIndex(['session_id']);
            $table->dropIndex(['is_unique_visitor', 'created_at']);
            
            $table->dropColumn([
                'country_code', 'country_name', 'region', 'city', 'latitude', 'longitude',
                'device_type', 'browser_name', 'browser_version', 'operating_system', 'screen_resolution',
                'traffic_source', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
                'session_id', 'is_unique_visitor', 'session_duration', 'is_bot', 'language', 'timezone'
            ]);
        });
    }
};