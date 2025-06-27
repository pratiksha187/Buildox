<?php

namespace App\Http\Controllers;
use App\Models\ProjectInformation;
use App\Models\ProjectDetails;
use App\Models\ProjectInquiry;
use Illuminate\Support\Facades\DB;
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
        'role' => 'required',
        'construction_type' => 'required',
        'project_type' => 'required',
        'sub_categories' => 'nullable|array',
        'plot_ready' => 'required|boolean',
    ]);

    // Check for duplicate
    if (ProjectInformation::where('phone_number', $validated['phone_number'])->exists()) {
        return response()->json([
            'status' => 'exists',
            'message' => 'This phone number has already been submitted.'
        ], 409);
    }

    // Save the record
    ProjectInformation::create([
        'full_name' => $validated['full_name'],
        'phone_number' => $validated['phone_number'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'construction_type' => $validated['construction_type'],  // <-- FIXED
        'plot_ready' => $validated['plot_ready'],
        'project_type' =>$validated['project_type'],
        'sub_categories' => $request->has('sub_categories') ? json_encode($request->sub_categories) : null,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Saved successfully',
    ]);
}




    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'full_name' => 'required|string|max:255',
    //         'phone_number' => 'required|string|max:20',
    //         'email' => 'nullable|email|max:255',
    //         'role' => 'required|integer',
    //         'construction_type' => 'required|array',
    //         'plot_ready' => 'required|boolean',
    //     ]);

    //     // Check if a record with the same phone number already exists
    //     $exists = ProjectInformation::where('phone_number', $validated['phone_number'])->exists();

    //     if ($exists) {
    //         return response()->json([
    //             'message' => 'This phone number has already been submitted.',
    //             'status' => 'exists'
    //         ], 409); // 409 Conflict
    //     }

    //     // Save new data
    //     ProjectInformation::create($validated);

    //     return response()->json([
    //         'message' => 'Saved successfully',
    //         'status' => 'success'
    //     ]);
    // }

    public function more_about_project(){
        return view('customer.more_about_project');
    }

    public function project_details(){
        return view('customer.project_detail');
    }

    public function project_details_store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            // 'project_name' => 'required|string|max:255|unique:project_name',

            'project_name' => 'required|string|max:255',
            'project_type' => 'required|string',
            'project_description' => 'required|string',
            'budget_range' => 'required|string',
            'expected_timeline' => 'required|string',
            'upload' => 'nullable|array|max:5',
            'upload.*' => 'mimes:pdf,doc,jpg,png|max:10240',
        ]);

        // Check if project with same name already exists
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

        // Create record
        ProjectDetails::create([
            'project_name' => $validated['project_name'],
            'project_type' => $validated['project_type'],
            'project_description' => $validated['project_description'],
            'budget_range' => $validated['budget_range'],
            'expected_timeline' => $validated['expected_timeline'],
            'file_path' => json_encode($filePaths),
        ]);

        return response()->json([
            'message' => 'Project details submitted successfully!'
        ]);
    }

    public function conformation_page(){
        return view('customer.conformation_page');
    }

    public function customer_dashboard(){
         return view('customer.customer_dashboard');
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

}
