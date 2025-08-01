<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'login_as' => 'required',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'login_as' => $request->login_as,
        ]);

        return redirect('/login')->with('success', 'Registered successfully!');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = DB::table('users')->where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            if ($admin->login_as == 1) {
                session(['admin' => $admin]);
                return redirect('/admin_dashboard');
            } elseif ($admin->login_as == 2) {
                session(['engineer' => $admin]);
                return redirect('/engineer_dashboard');
            } else {
                return back()->with('error', 'Unauthorized role.');
            }
        }

        $vendor = DB::table('service_provider')->where('email', $request->email)->first();

        if ($vendor && Hash::check($request->password, $vendor->password)) {
            if ($vendor->login_as == 4) {
               
                session(['vendor_id' => $vendor->id]);
                return redirect('/vendor_confiermetion');
            } else {
                return back()->with('error', 'Unauthorized role.');
            }
        }

        $user = DB::table('project_information')->where('email', $request->email)->first();

        if ($user && $user->login_id == 3 && Hash::check($request->password, $user->password)) {
            $project_data = DB::table('projects_details')->where('project_id', $user->id)->first();

            session([
                'user' => $user,
                'project_id' => optional($project_data)->id
            ]);

            return redirect('/customer-dashboard');
        }

        return back()->with('error', 'Invalid credentials or unauthorized user.');
    }


    public function logout() {
        session()->forget('user');
        return redirect('/');
    }
}
