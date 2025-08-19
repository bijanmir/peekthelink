<?php

namespace App\Http\Controllers;

use App\Services\RevenueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $revenueService;
    
    public function __construct(RevenueService $revenueService)
    {
        $this->revenueService = $revenueService;
    }

    /**
     * Handle Amazon Associates webhook
     */
    public function amazonWebhook(Request $request)
    {
        try {
            // Verify Amazon webhook signature (implement based on Amazon's documentation)
            if (!$this->verifyAmazonSignature($request)) {
                return response()->json(['error' => 'Invalid signature'], 401);
            }
            
            $payload = $request->json()->all();
            
            // Process each conversion
            foreach ($payload['conversions'] ?? [] as $conversion) {
                $linkId = $this->getLinkIdFromAmazonTag($conversion['associate_tag']);
                
                if ($linkId) {
                    $this->revenueService->trackConversion($linkId, [
                        'type' => 'sale',
                        'revenue_amount' => $conversion['purchase_amount'],
                        'commission_amount' => $conversion['commission_amount'],
                        'currency' => $conversion['currency'] ?? 'USD',
                        'order_id' => $conversion['order_id'],
                        'conversion_date' => $conversion['purchase_date'],
                        'auto_verify' => true, // Amazon data is already verified
                        'metadata' => [
                            'amazon_asin' => $conversion['asin'] ?? null,
                            'amazon_program' => 'Associates',
                        ]
                    ]);
                }
            }
            
            Log::info('Amazon webhook processed successfully', ['conversions' => count($payload['conversions'] ?? [])]);
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Amazon webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }

    /**
     * Handle Stripe webhook for direct sales
     */
    public function stripeWebhook(Request $request)
    {
        try {
            // Verify Stripe webhook signature
            $endpoint_secret = config('services.stripe.webhook_secret');
            $payload = $request->getContent();
            $sig_header = $request->header('Stripe-Signature');
            
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            
            if ($event['type'] === 'checkout.session.completed') {
                $session = $event['data']['object'];
                $linkId = $session['metadata']['link_id'] ?? null;
                
                if ($linkId) {
                    $this->revenueService->trackConversion($linkId, [
                        'type' => 'sale',
                        'revenue_amount' => $session['amount_total'] / 100, // Stripe uses cents
                        'commission_amount' => $session['amount_total'] / 100, // Full amount for direct sales
                        'currency' => strtoupper($session['currency']),
                        'transaction_id' => $session['payment_intent'],
                        'conversion_date' => now(),
                        'auto_verify' => true,
                        'metadata' => [
                            'stripe_session_id' => $session['id'],
                            'customer_email' => $session['customer_details']['email'] ?? null,
                        ]
                    ]);
                }
            }
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }

    /**
     * Handle ClickBank webhook
     */
    public function clickbankWebhook(Request $request)
    {
        try {
            // ClickBank sends data via POST
            $data = $request->all();
            
            // Verify ClickBank signature (implement based on their documentation)
            if (!$this->verifyClickBankSignature($request)) {
                return response()->json(['error' => 'Invalid signature'], 401);
            }
            
            if ($data['transactionType'] === 'SALE') {
                $linkId = $this->getLinkIdFromClickBankAffiliate($data['affiliate']);
                
                if ($linkId) {
                    $this->revenueService->trackConversion($linkId, [
                        'type' => 'sale',
                        'revenue_amount' => $data['orderTotalUsd'],
                        'commission_amount' => $data['affiliateCommissionUsd'],
                        'currency' => 'USD',
                        'order_id' => $data['receipt'],
                        'conversion_date' => $data['transactionTime'],
                        'auto_verify' => true,
                        'metadata' => [
                            'clickbank_receipt' => $data['receipt'],
                            'product_title' => $data['productTitle'],
                        ]
                    ]);
                }
            }
            
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('ClickBank webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }

    /**
     * Manual conversion tracking (for testing or manual entry)
     */
    public function manualConversion(Request $request)
    {
        $request->validate([
            'link_id' => 'required|exists:links,id',
            'revenue_amount' => 'required|numeric|min:0',
            'commission_amount' => 'nullable|numeric|min:0',
            'order_id' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        try {
            $conversion = $this->revenueService->trackConversion($request->link_id, [
                'type' => 'sale',
                'revenue_amount' => $request->revenue_amount,
                'commission_amount' => $request->commission_amount ?? $request->revenue_amount,
                'currency' => 'USD',
                'order_id' => $request->order_id,
                'conversion_date' => now(),
                'auto_verify' => false, // Manual entries need verification
                'metadata' => [
                    'entry_type' => 'manual',
                    'notes' => $request->notes,
                ]
            ]);
            
            return response()->json([
                'status' => 'success',
                'conversion_id' => $conversion->id,
                'message' => 'Conversion tracked successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Verify Amazon webhook signature
     */
    private function verifyAmazonSignature(Request $request)
    {
        // Implement Amazon's signature verification
        // This is a placeholder - check Amazon's webhook documentation
        return true;
    }

    /**
     * Verify ClickBank signature
     */
    private function verifyClickBankSignature(Request $request)
    {
        // Implement ClickBank's signature verification
        // This is a placeholder - check ClickBank's documentation
        return true;
    }

    /**
     * Get link ID from Amazon associate tag
     */
    private function getLinkIdFromAmazonTag($tag)
    {
        // Extract link ID from your custom affiliate tag format
        // E.g., if your tag is "yoursite-linkid123-20", extract linkid123
        if (preg_match('/linkid(\d+)/', $tag, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Get link ID from ClickBank affiliate ID
     */
    private function getLinkIdFromClickBankAffiliate($affiliate)
    {
        // Extract link ID from your affiliate tracking format
        // Implementation depends on how you format your affiliate IDs
        return null; // Implement based on your system
    }
}