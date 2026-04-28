<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewMemberWelcomeMail;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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

<<<<<<< HEAD
            // $staff = DB::table('hr.staff as t1')
            //     ->leftJoin('hr.promotion as t4', 't1.staff_no', '=', 't4.staff_no')
            //     ->leftJoin('hr.unit as t3', 't4.unit_id', '=', 't3.id')
            //     ->leftJoin('hr.unit as t6', 't1.unit_id', '=', 't6.id')
            //     ->leftJoin('hr.job as t5', 't4.job_id', '=', 't5.id')
            //     ->leftJoin('hr.job as t7', 't1.job_id', '=', 't7.id')
            //     ->leftJoin('provident_fund.users as t2', 't1.staff_no', '=', 't2.staff_no')
            //     ->select('t1.*', 't3.long_name as department', 't6.long_name as department_staff', 't5.title as job_title', 't7.title as job_title_staff')
            //     ->where('t1.ucc_mail', $googleUser->getEmail())->first();

            // using relationships instead of joins
            // first get the staff record, it should have relationships to unit and job
            // but you have to link it to the users record
            // and then select the department and job title from the related records
            // where the ucc_mail in the staff table matches the google email
            // $staff = Staff::with(['unit', 'job', 'staff.users'])->where('ucc_mail', $googleUser->getEmail())->first();
            $staff = Staff::with([
                'promotion.unit', // t3 (department)
                'promotion.job',  // t5 (job_title)
                'unit',           // t6 (department_staff)
                'job',            // t7 (job_title_staff)
                'user',            // t2 (provident fund user)
            ])
                ->where('ucc_mail', $googleUser->getEmail())
                ->first();
            // dd($staff);
=======
            // using relationships instead of joins

>>>>>>> 2705002 (staff and user models edited)
            // $staff = DB::table('hr.staff')->where('ucc_mail', $googleUser->getEmail())->first();
            // $staff->department = $staff->department ?? $staff->department_staff;
            // $staff->job_title = $staff->job_title ?? $staff->job_title_staff;
            // $staff->dob = $staff->dob ?? null;
            // dd($staff);
            // generate api key
            // $api_key = Str::random(60);
            $password = Str::random(16);

            if (! $user) {
                // Create new user
                if (! $staff) {
                    return redirect('/')->with('error', 'Record not found');
                } else {
                    $user = User::create([
                        'fname' => $staff->fname,
                        'mname' => $staff->mname,
                        'lname' => $staff->lname,
                        'phone_no' => $staff->phone,
                        'staff_no' => $staff->staff_no,
                        'date_of_birth' => $staff->dob,
                        'company' => $staff->department,
                        'job_title' => $staff->job_title,
                        // 'api_key' => $api_key,
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => bcrypt($password), // random password
                    ]);

                    $role_user = RoleUser::create([
                        'user_id' => $user->id,
                        'role_id' => 2,
                    ]);

                    Mail::to($googleUser->getEmail())->send(new NewMemberWelcomeMail($user, $password));

                }

            } else {
                // Update google_id if missing
                if ($user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }
            }

            Auth::login($user);

            return redirect('/dashboard'); // change as needed

        } catch (\Exception $e) {
            // dd($e->getMessage());

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
