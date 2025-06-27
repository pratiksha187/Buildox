<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessRegistration;

class AdminController extends Controller
{
    public function admin_dashboard(){
        return view('admin.admin_dashboard');
    }

    public function vender_approve_data(){
        $vendors = BusinessRegistration::where('approved', 1)->get(); 
        return view('admin.vender_approve_data', compact('vendors'));
    }

    public function vender_reject_data(){
        $vendors = BusinessRegistration::where('approved', 2)->get(); 
        return view('admin.vender_reject_data', compact('vendors'));
    }

    

    public function vender_approve_form()
    {
        $vendors = BusinessRegistration::where('approved', 0)->get(); 
        return view('admin.vender_approve_form', compact('vendors'));
    }


    
}
