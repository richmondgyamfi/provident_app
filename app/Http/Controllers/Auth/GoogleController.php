<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();
            $staff = DB::table('hr.staff')->where('ucc_mail', $googleUser->getEmail())->first();

            //generate api key
            $api_key = Str::random(60);
            $password = Str::random(16);

            if (!$user) {
                // Create new user
                if(!$staff){
                    return redirect('/')->with('error', 'Record not found');
                }else{
                    $user = User::create([
                        'fname' => $staff->fname,
                        'mname' => $staff->mname,
                        'lname' => $staff->lname,
                        'phone_no' => $staff->phone,
                        'staff_no' => $staff->staff_no,
                        'api_key' => $api_key,
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => bcrypt($password), // random password
                    ]);

                    $role_user = RoleUser::create([
                        'user_id' => $user->id,
                        'role_id' => 2,
                    ]);

                }
                
            } else {
                // Update google_id if missing
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId()
                    ]);
                }
            }

            Auth::login($user);

            return redirect('/dashboard'); // change as needed

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Google login failed');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}