<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    /**
     * Check if username is available
     */
    public function checkUsername(Request $request)
    {
        try {
            $username = $request->input('username');
            
            // Log the request for debugging
            Log::info('Username check request', ['username' => $username]);
            
            // Basic validation first
            if (empty($username)) {
                return response()->json([
                    'available' => false,
                    'message' => 'Username is required'
                ]);
            }
            
            if (strlen($username) < 3) {
                return response()->json([
                    'available' => false,
                    'message' => 'Username must be at least 3 characters'
                ]);
            }
            
            if (strlen($username) > 30) {
                return response()->json([
                    'available' => false,
                    'message' => 'Username cannot exceed 30 characters'
                ]);
            }
            
            // Check format
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                return response()->json([
                    'available' => false,
                    'message' => 'Username can only contain letters, numbers, and underscores'
                ]);
            }
            
            // Check reserved usernames
            $reserved = ['admin','api','www','test','demo','support','help','contact','info','sales','marketing','team','blog','news','about','privacy','terms','legal','security','app','mobile','web','site','mail','email','ftp','root','user','guest','public','private','docs','documentation','guide','tutorial','example','sample','peekthelink','peek','link','links','url','redirect'];
            
            if (in_array(strtolower($username), $reserved)) {
                return response()->json([
                    'available' => false,
                    'message' => 'This username is reserved and cannot be used',
                    'suggested' => $this->generateSuggestions($username)
                ]);
            }

            // Check if username exists in database
            $exists = User::where('username', $username)->exists();

            $response = [
                'available' => !$exists,
                'message' => $exists ? 'Username is already taken' : 'Username is available'
            ];
            
            if ($exists) {
                $response['suggested'] = $this->generateSuggestions($username);
            }
            
            Log::info('Username check response', $response);
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('Username check error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'available' => false,
                'message' => 'Unable to check username availability',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Generate username suggestions if taken
     */
    private function generateSuggestions($username)
    {
        $suggestions = [];
        $baseUsername = preg_replace('/\d+$/', '', $username); // Remove trailing numbers
        
        for ($i = 1; $i <= 3; $i++) {
            $suggestion = $baseUsername . rand(10, 999);
            if (!User::where('username', $suggestion)->exists()) {
                $suggestions[] = $suggestion;
            }
        }
        
        return $suggestions;
    }

    /**
     * Validate email availability
     */
    public function checkEmail(Request $request)
    {
        try {
            $email = $request->input('email');
            
            if (empty($email)) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Email is required'
                ]);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Please enter a valid email address'
                ]);
            }

            $exists = User::where('email', $email)->exists();

            return response()->json([
                'valid' => !$exists,
                'available' => !$exists,
                'message' => $exists ? 'Email is already registered' : 'Email is available'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Email check error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'valid' => false,
                'message' => 'Unable to check email availability'
            ], 500);
        }
    }

    /**
     * Register new user
     */
    public function register(Request $request)
    {
        try {
            Log::info('Registration attempt started', ['data' => $request->all()]);

            // Simple validation
            $fullName = $request->input('fullName');
            $username = $request->input('username');
            $email = $request->input('email');
            $password = $request->input('password');
            $passwordConfirmation = $request->input('password_confirmation');
            $terms = $request->input('terms');

            // Validate required fields
            if (empty($fullName)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['fullName' => ['Please enter your full name']]
                ], 422);
            }

            if (empty($username) || strlen($username) < 3) {
                return response()->json([
                    'success' => false,
                    'errors' => ['username' => ['Username must be at least 3 characters']]
                ], 422);
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => ['Please enter a valid email address']]
                ], 422);
            }

            if (empty($password) || strlen($password) < 8) {
                return response()->json([
                    'success' => false,
                    'errors' => ['password' => ['Password must be at least 8 characters']]
                ], 422);
            }

            if ($password !== $passwordConfirmation) {
                return response()->json([
                    'success' => false,
                    'errors' => ['password' => ['Password confirmation does not match']]
                ], 422);
            }

            if (!$terms) {
                return response()->json([
                    'success' => false,
                    'errors' => ['terms' => ['You must agree to the Terms and Privacy Policy']]
                ], 422);
            }

            // Check if username already exists
            if (User::where('username', $username)->exists()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['username' => ['This username is already taken']]
                ], 422);
            }

            // Check if email already exists
            if (User::where('email', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => ['This email is already registered']]
                ], 422);
            }

            // Create user
            $user = User::create([
                'name' => $fullName,
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(), // Auto-verify for demo
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            // IMPORTANT: Log the user in immediately
            auth()->login($user, true); // The 'true' enables "remember me"
            
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            Log::info('User registered and logged in', [
                'user_id' => $user->id,
                'username' => $user->username,
                'auth_check' => auth()->check()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'profile_url' => url('/' . $user->username)
                ],
                'redirect_url' => route('dashboard'),
                'auth_status' => auth()->check() // Debug info
            ]);

        } catch (\Exception $e) {
            Log::error('Registration error', [
                'error' => $e->getMessage(), 
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Check password strength
     */
    public function checkPasswordStrength(Request $request)
    {
        try {
            $password = $request->input('password');
            
            $requirements = [
                'length' => strlen($password) >= 8,
                'uppercase' => preg_match('/[A-Z]/', $password),
                'lowercase' => preg_match('/[a-z]/', $password),
                'number' => preg_match('/[0-9]/', $password),
                'special' => preg_match('/[^A-Za-z0-9]/', $password)
            ];

            $score = array_sum($requirements);
            
            $strength = [
                0 => 'very-weak',
                1 => 'weak', 
                2 => 'fair',
                3 => 'good',
                4 => 'strong',
                5 => 'very-strong'
            ];

            return response()->json([
                'score' => $score,
                'strength' => $strength[$score] ?? 'weak',
                'requirements' => $requirements,
                'valid' => $score >= 3 // Require at least 3 criteria
            ]);
            
        } catch (\Exception $e) {
            Log::error('Password strength check error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'score' => 0,
                'strength' => 'weak',
                'requirements' => [],
                'valid' => false
            ], 500);
        }
    }
}