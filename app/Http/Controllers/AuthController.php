<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Register a new user with institutional email.
     */
    public function register(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'ends_with:@ucc.edu.gh'],
            'phone_no' => ['required', 'string', 'digits_between:1,15', 'unique:users,phone_no'],
            'staff_no' => ['required', 'string', 'max:50', 'unique:users,staff_no'],
            'role' => ['required', 'string', 'max:10'],
            'account_type' => ['required', 'string', 'max:10'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        // check from hr.staff to get the details using email
        // $staffRecord = DB::table('hr.staff')->where('email', $validated['email'])->first();

        // if (!$staffRecord) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Email not found in staff records. Please use your institutional email.',
        //     ], 422);
        // }

        try {
            // Use database transaction for data integrity
            $user = DB::transaction(function () use ($validated) {
            return User::create([
                'fname' => $validated['fname'],
                'mname' => $validated['mname'] ?? null,
                'lname' => $validated['lname'],
                'email' => $validated['email'],
                'phone_no' => $validated['phone_no'],
                'staff_no' => $validated['staff_no'],
                'role' => $validated['role'],
                'account_type' => $validated['account_type'],
                // Laravel automatically hashes password due to 'hashed' cast in User model
                'password' => $validated['password'],
                'api_key' => Str::random(50),
                'is_active' => true,
            ]);
            });

            // Fire the Registered event (automatically sends verification email if MustVerifyEmail is implemented)
            event(new Registered($user));
            // return redirect()->back()->with('success','User Account Created Successfully');

            return redirect()->route('register')->with('success', 'User registered successfully. Please verify your email.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database constraint violations
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Registration failed. Please check your input and try again.',
            //     'errors' => ['database' => 'A duplicate entry may exist.'],
            // ], 422);
            // return redirect()->route('register')->with('error', 'An unexpected error occurred during registration.');
            return redirect()->back()->with('error','Registration failed. Please check your input and try again.');

        } catch (\Exception $e) {
            // Handle any unexpected errors
            // return response()->json([
            //     'success' => false,
            //     'message' => 'An unexpected error occurred during registration.',
            // ], 500);
            return redirect()->route('register')->with('error', 'An unexpected error occurred during registration.');

        }
    }
}
