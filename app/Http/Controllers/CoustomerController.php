<?php

namespace App\Http\Controllers;
use App\Models\ProjectInformation;
use App\Models\ProjectDetails;
use App\Models\ProjectInquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class CoustomerController extends Controller
{
    public function home(){
        return view('home');
    }
   
    public function project()
    {
        // Assuming your construction types are stored in a `construction_types` table
        $construction_types = DB::table('categories')->orderBy('id')->get();

        return view('customer.project', compact('construction_types'));
    }

    public function getProjectTypes($constructionTypeId)
    {
        $projectTypes = DB::table('project_types')
            ->where('category_id', $constructionTypeId)
            ->select('id', 'name')
            ->get();

        return response()->json($projectTypes);
    }

    public function getSubcategories($project_type_id)
    {
        $subs = DB::table('construction_sub_categories')
                ->where('project_type_id', $project_type_id)
                ->get(['id', 'name']);

        return response()->json($subs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'password' => 'required',
            'role' => 'required',
            'construction_type' => 'required',
            'project_type' => 'required',
            'sub_categories' => 'nullable|array',
            'plot_ready' => 'required|boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Check for duplicate phone number
        if (ProjectInformation::where('phone_number', $validated['phone_number'])->exists()) {
            return response()->json([
                'status' => 'exists',
                'message' => 'This phone number has already been submitted.'
            ], 409);
        }

        // Handle profile image upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Save to DB
        $project = ProjectInformation::create([
            'full_name' => $validated['full_name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'password' =>  Hash::make($validated['password']),
            'role' => $validated['role'],
            'construction_type' => $validated['construction_type'],
            'project_type' => $validated['project_type'],
            'sub_categories' => $request->has('sub_categories') ? json_encode($request->sub_categories) : null,
            'plot_ready' => $validated['plot_ready'],
            'profile_image' => $imagePath,
            'login_id' => 3
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Saved successfully',
            'project_id' => $project->id,
        ]);
    }


    public function more_about_project(){
        return view('customer.more_about_project');
    }

    public function project_details($id){
        $project = ProjectInformation::findOrFail($id);
        //  return view('project.details', compact('project'));
        return view('customer.project_detail', compact('project'));
    }

    public function project_details_store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
           
            'project_id' => 'required|integer|exists:project_information,id',
            'project_name' => 'required|string|max:255',
            'project_location' => 'required|string',
            'project_description' => 'required|string',
            'budget_range' => 'required|string',
            'expected_timeline' => 'required|string',
            'upload' => 'nullable|array|max:5',
            'upload.*' => 'mimes:pdf,doc,jpg,png|max:10240',
        ]);

     
        $exists = ProjectDetails::where('project_name', $validated['project_name'])->exists();

        if ($exists) {
            return response()->json([
                'exists' => 'A project with this name already exists.'
            ], 422);
        }

        // File upload handling
        $filePaths = [];
        if ($request->hasFile('upload')) {
            foreach ($request->file('upload') as $file) {
                $filePaths[] = $file->store('project_documents', 'public');
            }
        }

        $year = now()->year;
        $prefix = 'BX'; 

        $count = ProjectDetails::whereYear('created_at', $year)->count() + 1;
        $code = sprintf('%s-%d-%03d', $prefix, $year, $count);
        
        ProjectDetails::create([
            'project_name' => $validated['project_name'],
            'project_location' => $validated['project_location'],
            'project_description' => $validated['project_description'],
            'budget_range' => $validated['budget_range'],
            'expected_timeline' => $validated['expected_timeline'],
            'file_path' => json_encode($filePaths),
            'project_id' =>$validated['project_id'],
            'submission_id' => $code,
        ]); 

        return response()->json([
            'message' => 'Project details submitted successfully!'
        ]);
    }

         // Controller
    public function storeProjectSession(Request $request)
    {
        session(['project_id' => $request->project_id]);
        return response()->json(['success' => true]);
    }

    public function conformation_page(Request $request){
        // $project_id = $request->query('project_id'); 
        $project_id = session('project_id');
        if (!$project_id) {
            return redirect()->back()->withErrors('Project ID not found');
        }
        $get_project_det = DB::table('projects_details')
                        ->where('id', $project_id)
                        ->first();

                // print_r($get_project_det);die;
        return view('customer.conformation_page', compact('project_id','get_project_det'));
    }

   
    public function customer_dashboard()
    {
        $project_id = session('project_id');
    // print_r($project_id);die;
        $get_project_det = DB::table('projects_details')
            ->where('id', $project_id)
            ->get();
        // print_r($get_project_det);die;
        $firstProject = $get_project_det->first();

        if (!$firstProject) {
            return redirect()->back()->with('error', 'Project not found.');
        }

        $proj_data = DB::table('project_information')
            ->where('id', $firstProject->project_id)
            ->first();
        return view('customer.customer_dashboard', compact('project_id', 'proj_data', 'get_project_det'));
    }


    public function need_help(){
        return view('customer.about_project');
    }

    public function projectinquiry(Request $request)
    {
         $validator = \Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email',
        'project_type' => 'required|string',
        'project_brief' => 'nullable|string',
        'preferred_day' => 'nullable|string',
        'preferred_time' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    ProjectInquiry::create($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Your inquiry has been submitted successfully!',
    ]);
    }

    public function customer_details()
    {
        $project = DB::table('projects_details')->latest('id')->first();
        return view('customer.customer_details', compact('project'));
    }


   public function updateAction(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'confirm' => 'required|integer',
        ]);

        $updated = DB::table('projects_details')
            ->where('id', $request->project_id)
            ->update(['confirm' => $request->confirm]);

        // Return success even if 0 rows changed (value already set)
        return response()->json([
            'status' => 'success',
            'message' => $updated ? 'Updated successfully' : 'No change needed'
        ]);
    }


}
