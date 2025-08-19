<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->foreignId('link_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('click_id')->nullable(); // Reference to specific click
            
            // Conversion details
            $table->enum('conversion_type', ['sale', 'lead', 'subscription', 'commission', 'click'])->default('sale');
            $table->decimal('revenue_amount', 12, 2); // Total sale amount
            $table->decimal('commission_amount', 12, 2); // Your commission
            $table->string('currency', 3)->default('USD');
            
            // External tracking
            $table->string('order_id')->nullable(); // External order ID
            $table->string('transaction_id')->nullable(); // Payment processor ID
            $table->string('affiliate_program')->nullable(); // Amazon, ClickBank, etc.
            $table->json('metadata')->nullable(); // Additional data
            
            // Verification and status
            $table->boolean('is_verified')->default(false);
            $table->timestamp('conversion_date');
            $table->timestamp('verification_date')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'refunded'])->default('pending');
            
            // Notes
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'conversion_date']);
            $table->index(['link_id', 'conversion_date']);
            $table->index(['conversion_type', 'status']);
            $table->index(['affiliate_program', 'status']);
            $table->index(['is_verified', 'conversion_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};