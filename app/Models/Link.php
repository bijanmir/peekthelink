<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'url',
        'description',
        'order',
        'is_active',
        'clicks',
        
        // New revenue fields
        'link_type',
        'commission_rate',
        'estimated_value',
        'sponsored_rate',
        'affiliate_program',
        'affiliate_tag',
        'conversions',
        'total_revenue',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'clicks' => 'integer',
        'conversions' => 'integer',
        'commission_rate' => 'decimal:2',
        'estimated_value' => 'decimal:2',
        'sponsored_rate' => 'decimal:2',
        'total_revenue' => 'decimal:2',
    ];

    /**
     * Get the user that owns the link
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all clicks for this link
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(LinkClick::class);
    }

    /**
     * Get all conversions for this link
     */
    public function conversions(): HasMany
    {
        return $this->hasMany(Conversion::class);
    }

    /**
     * Get verified conversions only
     */
    public function verifiedConversions(): HasMany
    {
        return $this->hasMany(Conversion::class)->verified();
    }

    /**
     * Scope for affiliate links
     */
    public function scopeAffiliate($query)
    {
        return $query->where('link_type', 'affiliate');
    }

    /**
     * Scope for sponsored links
     */
    public function scopeSponsored($query)
    {
        return $query->where('link_type', 'sponsored');
    }

    /**
     * Scope for product links
     */
    public function scopeProduct($query)
    {
        return $query->where('link_type', 'product');
    }

    /**
     * Get conversion rate for this link
     */
    public function getConversionRateAttribute()
    {
        if ($this->clicks == 0) return 0;
        return round(($this->conversions / $this->clicks) * 100, 2);
    }

    /**
     * Get revenue per click
     */
    public function getRevenuePerClickAttribute()
    {
        if ($this->clicks == 0) return 0;
        return round($this->total_revenue / $this->clicks, 4);
    }

    /**
     * Get estimated monthly revenue based on current performance
     */
    public function getEstimatedMonthlyRevenueAttribute()
    {
        // Get clicks from last 30 days
        $monthlyClicks = $this->clicks()
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
            
        if ($monthlyClicks == 0) return 0;
        
        return $monthlyClicks * $this->revenue_per_click;
    }

    /**
     * Calculate potential revenue for this link
     */
    public function calculatePotentialRevenue()
    {
        switch ($this->link_type) {
            case 'affiliate':
                // Estimated value × commission rate × estimated conversion rate
                $estimatedConversionRate = max($this->conversion_rate / 100, 0.02); // Min 2%
                return $this->estimated_value * ($this->commission_rate / 100) * $estimatedConversionRate;
                
            case 'sponsored':
                // Fixed rate per click
                return $this->sponsored_rate;
                
            case 'product':
                // Full product value × conversion rate
                $estimatedConversionRate = max($this->conversion_rate / 100, 0.05); // Min 5% for own products
                return $this->estimated_value * $estimatedConversionRate;
                
            default:
                return 0;
        }
    }

    /**
     * Track a conversion for this link
     */
    public function trackConversion($data)
    {
        $conversion = $this->conversions()->create([
            'user_id' => $this->user_id,
            'click_id' => $data['click_id'] ?? null,
            'conversion_type' => $data['type'] ?? 'sale',
            'revenue_amount' => $data['revenue_amount'],
            'commission_amount' => $data['commission_amount'],
            'currency' => $data['currency'] ?? 'USD',
            'order_id' => $data['order_id'] ?? null,
            'transaction_id' => $data['transaction_id'] ?? null,
            'affiliate_program' => $this->affiliate_program,
            'metadata' => $data['metadata'] ?? null,
            'conversion_date' => $data['conversion_date'] ?? now(),
            'status' => $data['status'] ?? 'pending',
        ]);

        // Auto-verify if specified
        if ($data['auto_verify'] ?? false) {
            $conversion->verify();
        }

        return $conversion;
    }

    /**
     * Get performance summary
     */
    public function getPerformanceSummary($days = 30)
    {
        $startDate = now()->subDays($days);
        
        $recentClicks = $this->clicks()
            ->where('created_at', '>=', $startDate)
            ->count();
            
        $recentConversions = $this->conversions()
            ->confirmed()
            ->where('conversion_date', '>=', $startDate)
            ->count();
            
        $recentRevenue = $this->conversions()
            ->confirmed()
            ->where('conversion_date', '>=', $startDate)
            ->sum('commission_amount');

        return [
            'clicks' => $recentClicks,
            'conversions' => $recentConversions,
            'revenue' => $recentRevenue,
            'conversion_rate' => $recentClicks > 0 ? round(($recentConversions / $recentClicks) * 100, 2) : 0,
            'revenue_per_click' => $recentClicks > 0 ? round($recentRevenue / $recentClicks, 4) : 0,
        ];
    }
}