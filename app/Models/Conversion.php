<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Conversion extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'user_id', 
        'click_id',
        'conversion_type',
        'revenue_amount',
        'commission_amount',
        'currency',
        'order_id',
        'transaction_id',
        'affiliate_program',
        'metadata',
        'is_verified',
        'conversion_date',
        'verification_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'revenue_amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'metadata' => 'array',
        'is_verified' => 'boolean',
        'conversion_date' => 'datetime',
        'verification_date' => 'datetime',
    ];

    /**
     * Get the link this conversion belongs to
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    /**
     * Get the user this conversion belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the click that led to this conversion
     */
    public function click(): BelongsTo
    {
        return $this->belongsTo(LinkClick::class, 'click_id');
    }

    /**
     * Scope for verified conversions only
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for confirmed conversions
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for pending conversions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for specific date range
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('conversion_date', [$startDate, $endDate]);
    }

    /**
     * Get total revenue for user in date range
     */
    public static function getTotalRevenue($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)->confirmed();
        
        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }
        
        return $query->sum('commission_amount');
    }

    /**
     * Get conversion rate for a link
     */
    public static function getConversionRate($linkId)
    {
        $totalClicks = LinkClick::where('link_id', $linkId)->count();
        $totalConversions = self::where('link_id', $linkId)->confirmed()->count();
        
        if ($totalClicks == 0) return 0;
        
        return round(($totalConversions / $totalClicks) * 100, 2);
    }

    /**
     * Get revenue by affiliate program
     */
    public static function getRevenueByProgram($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->confirmed()
            ->select('affiliate_program', DB::raw('SUM(commission_amount) as total_revenue'))
            ->groupBy('affiliate_program')
            ->orderBy('total_revenue', 'desc');
            
        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }
        
        return $query->get();
    }

    /**
     * Mark conversion as verified
     */
    public function verify()
    {
        $this->update([
            'is_verified' => true,
            'verification_date' => now(),
            'status' => 'confirmed'
        ]);

        // Update link's total revenue
        $this->link()->increment('total_revenue', $this->commission_amount);
        $this->link()->increment('conversions');

        return $this;
    }

    /**
     * Cancel/refund conversion
     */
    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'notes' => $reason
        ]);

        // Decrease link's total revenue if it was previously confirmed
        if ($this->is_verified) {
            $this->link()->decrement('total_revenue', $this->commission_amount);
            $this->link()->decrement('conversions');
        }

        return $this;
    }
}