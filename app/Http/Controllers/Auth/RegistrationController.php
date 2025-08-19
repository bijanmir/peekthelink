<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

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
            \Log::info('Username check request', ['username' => $username]);
            
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
            
            \Log::info('Username check response', $response);
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            \Log::error('Username check error', ['error' => $e->getMessage()]);
            
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
        $email = $request->input('email');
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => $validator->errors()->first('email')
            ]);
        }

        $exists = User::where('email', $email)->exists();

        return response()->json([
            'valid' => !$exists,
            'available' => !$exists,
            'message' => $exists ? 'Email is already registered' : 'Email is available'
        ]);
    }

    /**
     * Register new user
     */
    public function register(Request $request)
    {
        // Comprehensive validation
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255|min:2',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/',
                'not_in:admin,api,www,test,demo,support,help,contact,info,sales,marketing,team,blog,news,about,privacy,terms,legal,security,app,mobile,web,site,mail,email,ftp,root,user,guest,public,private,docs,documentation,guide,tutorial,example,sample,peekthelink,peek,link,links,url,redirect'
            ],
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'required|accepted'
        ], [
            'fullName.required' => 'Please enter your full name',
            'fullName.min' => 'Name must be at least 2 characters',
            'username.required' => 'Please choose a username',
            'username.min' => 'Username must be at least 3 characters',
            'username.max' => 'Username cannot exceed 30 characters',
            'username.unique' => 'This username is already taken',
            'username.regex' => 'Username can only contain letters, numbers, and underscores',
            'username.not_in' => 'This username is reserved and cannot be used',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Please create a password',
            'password.confirmed' => 'Password confirmation does not match',
            'terms.accepted' => 'You must agree to the Terms of Service and Privacy Policy'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Please fix the errors below'
            ], 422);
        }

        try {
            // Create user
            $user = User::create([
                'name' => $request->fullName,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(), // Auto-verify for demo, remove in production
            ]);

            // Log the user in
            auth()->login($user);

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
                'redirect_url' => route('dashboard')
            ]);

        } catch (\Exception $e) {
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
    }
}