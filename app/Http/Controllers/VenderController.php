<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersLogin;
use App\Models\BusinessRegistration;
use App\Models\ProjectDetails;
use App\Models\AgencyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ServiceProvider;
use App\Models\ProjectLike;
use Illuminate\Support\Facades\Validator;

class VenderController extends Controller
{
    public function service_provider(){
        return view('vender.service_provider');
    }

    public function registerServiceProvider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15|unique:service_provider,mobile',
            'email' => 'required|email|unique:service_provider,email',
            'password' => 'required|string|min:6|confirmed',
            'location' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:50',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

       
        $vendor =  ServiceProvider::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'business_name' => $request->business_name,
            'gst_number' => $request->gst_number,
            'location' => $request->location,
            'password' => Hash::make($request->password),
        ]);
        $insertedId = $vendor->id;
        session(['vendor_id' => $insertedId]);
       
        return response()->json([
            'success' => true,
            'message' => 'Registration successful.'
        ], 200);
    }
    public function login_form(){
        return view('vender.venderlogin');
    }

    public function logout(Request $request)
    {
       
        $request->session()->forget('user_id'); 
        $request->session()->flush(); 
       
        $request->session()->regenerate();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
  
   
    public function venderlogin(Request $request)
    {
        $user = UsersLogin::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Set session
            session([
                'user_id' => $user->id,
                'role' => $user->role, // like 'admin', 'vendor', etc.
                'is_logged_in' => true
            ]);
            return redirect('/dashboard');
            return response()->json([
                'status' => 'success',
                'role' => $user->role,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password'
        ]);
    }

    public function types_of_agency(){
        $agencyTypes = DB::table('agency_types')->get(); 
        return view('vender.types_of_agency', compact('agencyTypes'));
    }

    public function getServices($agency_id)
    {
        $services = DB::table('services')
            ->where('agency_id', $agency_id)
            ->pluck('name', 'id');

        return response()->json($services);
    }

    public function save_agency_services(Request $request)
    {
        $validated = $request->validate([
            'agency_type' => 'required|string',
            'services' => 'required|array',
        ]);
        $vendor_id = session('vendor_id');
        AgencyService::create([
            'user_id' => $vendor_id,
            'agency_type' => $validated['agency_type'],
            'services' => json_encode($validated['services']),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Saved successfully']);
    }

    public function about_business(){
         return view('vender.about_business');
    }

   
    
    public function business_store(Request $request)
    {
        $validated = $request->validate([
            'experience_years' => 'required|string',
            'team_size' => 'required|string',
            'service_coverage_area' => 'required|string',
            'min_project_value' => 'required|numeric',
            'company_name' => 'required|string',
            'entity_type' => 'required|string',
            'registered_address' => 'required|string',
            'contact_person_designation' => 'required|string',
            'gst_number' => 'required|string',
            'pan_number' => 'required|string',
            'tan_number' => 'nullable|string',
            'esic_number' => 'nullable|string',
            'pf_code' => 'nullable|string',
            'msme_registered' => 'required|string',
            'pan_aadhar_seeded' => 'required|string',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'ifsc_code' => 'required|string',
            'account_type' => 'required|string',
            'cancelled_cheque_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'pan_card_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'aadhaar_card_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'certificate_of_incorporation_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'itr_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'turnover_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'work_completion_certificates_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'pf_esic_documents_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'company_profile_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'portfolio_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'past_work_photos_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'license_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'aadhar_section' =>'nullable',
            'cin_section' => 'nullable',
        ]);
        // $userId = session('user_id');
        $vendor_id = session('vendor_id');
        $approved = 0;
        $validated['user_id'] = $vendor_id;
        $validated['approved'] = $approved;
       
        $fileFields = [
            'cancelled_cheque_file', 'pan_card_file', 'aadhaar_card_file',
            'certificate_of_incorporation_file', 'itr_file', 'turnover_certificate_file',
            'work_completion_certificates_file', 'pf_esic_documents_file',
            'company_profile_file', 'portfolio_file', 'past_work_photos_file',
            'license_certificate_file'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('documents', 'public');
            }
        }

        BusinessRegistration::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Business registration data saved successfully!'
        ]);
    }

 

    public function vendor_confiermetion()
    {
        $vendor_id = session('vendor_id');

        return view('vender.vendor_confiermetion', [
            'vendor_id' => $vendor_id
        ]);
    }


    public function vendor_dashboard(){
        return view('vender.vendor_dashboard');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2',
        ]);


        $vendor = BusinessRegistration::findOrFail($id);
        $vendor->approved = $request->status;
        $vendor->save();

        return response()->json(['message' => 'Vendor status updated successfully.']);
    }



    public function showListPage()
    {
        return view('vender.list_of_project');
    }

     public function vendor_likes_project()
    {
        return view('vender.vendor_likes_project');
    }

    public function projectsData(Request $request)
    {
        $query = ProjectDetails::query();

        if ($request->filled('project_name')) {
            $query->where('project_name', 'like', '%' . $request->project_name . '%');
        }

        if ($request->filled('budget_range')) {
            $query->where('budget_range', 'like', '%' . $request->budget_range . '%');
        }

        return DataTables::of($query)->make(true);
    }

    // public function likeprojectsData(Request $request)
    // {
    //     $vendorId = $request->query('vendor_id');
    //     $query = ProjectDetails::query();

    //     if ($request->filled('project_name')) {
    //         $query->where('project_name', 'like', '%' . $request->project_name . '%');
    //     }

    //     if ($request->filled('budget_range')) {
    //         $query->where('budget_range', 'like', '%' . $request->budget_range . '%');
    //     }

    //     return DataTables::of($query)->make(true);
    // }
// public function likeprojectsData(Request $request)
// {
//     $vendorId = session('vendor_id');

//     // Start a plain DB query
//     $query = DB::table('project_likes');

//     // Filter by vendor_id (example: if you store likes in a separate table)
//     if ($vendorId) {
//         // Assuming `projects_details` has a column `liked_by` (adjust if needed)
//         $query->where('vendor_id', $vendorId);
        
//     }

//     return DataTables::of($query)->make(true);
// }
public function likeprojectsData(Request $request)
{
    $vendorId = session('vendor_id');

    // Join with projects_details table to get project information
    $query = DB::table('project_likes')
        ->join('projects_details', 'project_likes.project_id', '=', 'projects_details.id')
        ->where('project_likes.vendor_id', $vendorId)
        ->select(
            'projects_details.project_name',
            'projects_details.budget_range',
            'projects_details.expected_timeline',
            'projects_details.id'
        );

    // Optional: add filters if needed
    if ($request->project_name) {
        $query->where('projects_details.project_name', 'like', '%' . $request->project_name . '%');
    }

    if ($request->budget_range) {
        $query->where('projects_details.budget_range', 'like', '%' . $request->budget_range . '%');
    }

    return DataTables::of($query)->make(true);
}

    public function projectlikes(Request $request)
    {
        $vendor_id = session('vendor_id');

        $request->validate([
            'project_id' => 'required',
        ]);

        // Check if this vendor already liked this project
        $alreadyLiked = ProjectLike::where('project_id', $request->project_id)
                        ->where('vendor_id', $vendor_id)
                        ->exists();

        if ($alreadyLiked) {
            return response()->json(['message' => 'You already liked this project.'], 409); // 409 = Conflict
        }

        // Save the like
        ProjectLike::create([
            'project_id' => $request->project_id,
            'vendor_id' => $vendor_id,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Like recorded!']);
    }

    public function projectshow($id)
    {
        $project = ProjectDetails::findOrFail($id);

        return response()->json([
            'project_name' => $project->project_name,
            'budget_range' => $project->budget_range,
            'expected_timeline' => $project->expected_timeline,
        ]);
    }


}
