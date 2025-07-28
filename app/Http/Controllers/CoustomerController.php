<?php

namespace App\Http\Controllers;
use App\Models\ProjectInformation;
use App\Models\ProjectDetails;
use App\Models\ProjectInquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Razorpay\Api\Api;
use Illuminate\Contracts\Encryption\DecryptException;

class CoustomerController extends Controller
{
    public function home(){
        return view('home');
    }
   
    public function project()
    {
        $construction_types = DB::table('categories')->orderBy('id')->get();
        $role_types = DB::table('role')->get();
        return view('customer.project', compact('construction_types','role_types'));
    }

    public function getProjectTypes(Request $request)
    {
        $category_id = $request->construction_type_id;

        $types = DB::table('project_cat_type')
            ->join('project_types', 'project_cat_type.project_types_id', '=', 'project_types.id')
            ->where('project_cat_type.categories_id', $category_id)
            ->select('project_types.id', 'project_types.name')
            ->distinct()
            ->get();

        return response()->json($types);
    }


    public function getSubCategories(Request $request)
    {
        $project_type_id = $request->project_type_id;
        $category_id = $request->construction_type_id;

        // Join tables to get subcategory names
        $results = DB::table('project_cat_type')
            ->join('construction_sub_categories', 'project_cat_type.const_sub_cat_id', '=', 'construction_sub_categories.id')
            ->where('project_cat_type.project_types_id', $project_type_id)
            ->where('project_cat_type.categories_id', $category_id)
            ->select('construction_sub_categories.id as const_sub_cat_id', 'construction_sub_categories.name as sub_category_name')
            ->get();

        return response()->json($results);
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'full_name' => 'required|string|max:255',
    //         'phone_number' => 'required|string|max:20',
    //         'email' => 'nullable|email|max:255',
    //         'password' => 'required',
    //         'role' => 'required',
    //         // 'budget' => 'required',
    //         'construction_type' => 'required',
    //         'project_type' => 'required',
    //         'sub_categories' => 'nullable|array',
    //         // 'other_project_type' =>'nullable',
    //         'plot_ready' => 'required|boolean',
    //         'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //     ]);

    //     if ($request->plot_ready) {
    //         $request->validate([
    //             'land_location' => 'nullable|string|max:255',
    //             'land_type' => 'nullable|string|max:100',
    //             'survey_no' => 'nullable|string|max:100',
    //             'area' => 'nullable|numeric',
    //             'area_unit' => 'nullable|string|max:50',
    //             'has_arch_drawing' => 'nullable',
    //             'has_structural_drawing' => 'nullable',
    //             'boqCheckbox' => 'nullable',
    //             'boqFile' => 'nullable'
    //         ]);
    //     }

    //     if (ProjectInformation::where('phone_number', $validated['phone_number'])->exists()) {
    //         return response()->json([
    //             'status' => 'exists',
    //             'message' => 'This phone number has already been submitted.'
    //         ], 409);
    //     }

    //     $imagePath = null;
    //     if ($request->hasFile('profile_image')) {
    //         $imagePath = $request->file('profile_image')->store('profile_images', 'public');
    //     }
    //     $boqFilePath = null;
    //     if ($request->hasFile('boqFile')) {
    //         $boqFilePath = $request->file('boqFile')->store('boq_files', 'public');
    //     }

    //     $project = ProjectInformation::create([
    //         'full_name' => $validated['full_name'],
    //         'phone_number' => $validated['phone_number'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']),
    //         'role' => $validated['role'],
    //         'construction_type' => $validated['construction_type'],
    //         'project_type' => $validated['project_type'],
    //         'sub_categories' => $request->has('sub_categories') ? json_encode($request->sub_categories) : null,
    //         'plot_ready' => $validated['plot_ready'],
    //         'profile_image' => $imagePath,
    //         'login_id' => 3,
    //         'land_location' => $request->land_location,
    //         'land_type' => $request->land_type,
    //         'survey_no' => $request->survey_no,
    //         'area' => $request->area,
    //         'area_unit' => $request->area_unit,
    //         'other_project_type' =>$request->other_project_type,
    //         'has_arch_drawing' => $request->has('has_arch_drawing'),
    //         'has_structural_drawing' => $request->has('has_structural_drawing'),
    //         'boqFile' => $boqFilePath,
    //         'boqCheckbox' => $request->boqCheckbox
    //     ]);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Saved successfully',
    //         'project_id' => $project->id,
    //     ]);
    // }

  public function store(Request $request)
{
    // Step 1: Validate fields
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

    // Step 2: If plot_ready, validate extra fields
    if ($request->plot_ready) {
        $request->validate([
            'land_location' => 'nullable|string|max:255',
            'land_type' => 'nullable|string|max:100',
            'survey_no' => 'nullable|string|max:100',
            'area' => 'nullable|numeric',
            'area_unit' => 'nullable|string|max:50',
            'has_arch_drawing' => 'nullable',
            'has_structural_drawing' => 'nullable',
            'boqCheckbox' => 'nullable',
            'boqFile' => 'nullable|file',
        ]);
    }

    // Step 3: Check how many projects exist with same email
    if ($validated['email']) {
        $existingProjectCount = ProjectInformation::where('email', $validated['email'])->count();

        // Step 4: If already 3 or more, do not save — redirect to payment
        if ($existingProjectCount >= 3) {
            $encryptedEmail = Crypt::encryptString($validated['email']);
            return response()->json([
                'status' => 'payment_required',
                'message' => 'You have reached the project submission limit. Please proceed to payment before adding more.',
                'redirect_to_payment' => true,
                // 'payment_url' => route('payment_page') // You can pass extra data via session or query string
                'payment_url' => route('payment_page', ['email' => $encryptedEmail])
            ]);
        }
    }

    // Step 5: Handle file uploads
    $imagePath = null;
    if ($request->hasFile('profile_image')) {
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    $boqFilePath = null;
    if ($request->hasFile('boqFile')) {
        $boqFilePath = $request->file('boqFile')->store('boq_files', 'public');
    }

    // Step 6: Save project
    $project = ProjectInformation::create([
        'full_name' => $validated['full_name'],
        'phone_number' => $validated['phone_number'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
        'construction_type' => $validated['construction_type'],
        'project_type' => $validated['project_type'],
        'sub_categories' => $request->has('sub_categories') ? json_encode($request->sub_categories) : null,
        'plot_ready' => $validated['plot_ready'],
        'profile_image' => $imagePath,
        'login_id' => 3,
        'land_location' => $request->land_location,
        'land_type' => $request->land_type,
        'survey_no' => $request->survey_no,
        'area' => $request->area,
        'area_unit' => $request->area_unit,
        'other_project_type' => $request->other_project_type,
        'has_arch_drawing' => $request->has('has_arch_drawing'),
        'has_structural_drawing' => $request->has('has_structural_drawing'),
        'boqFile' => $boqFilePath,
        'boqCheckbox' => $request->boqCheckbox
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Project saved successfully.',
        'project_id' => $project->id,
    ]);
}


    public function payment_page($email)
    {
        try {
        $decryptedEmail = Crypt::decryptString($email);
        } catch (DecryptException $e) {
            abort(403, 'Invalid or tampered email data.');
        }

        // $project = ProjectInformation::findOrFail();
        return view('customer.payment_page',['email' => $decryptedEmail]);
    }
   
    public function razorpaypayment(Request $request){
    //    print_r($_POST);die;
        $amount = $request->input('amount');
        $api = new Api(env('RAZORPAY_KEY'),env('secret key'));
        $orderData = [
            'receipt' => 'order_'.rand(1000,9999),
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ];

        $order = $api->order->create($orderData);

        return view('customer.payment',['orderId' => $order["id"]]);

    }

    public function more_about_project(){
        return view('customer.more_about_project');
    }

    public function project_details($id){
        $project = ProjectInformation::findOrFail($id);
        return view('customer.project_detail', compact('project'));
    }

    public function project_details_store(Request $request)
    {
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


    public function storeProjectSession(Request $request)
    {
        session(['project_id' => $request->project_id]);
        return response()->json(['success' => true]);
    }
    public function conformation_page(Request $request){
        $project_id = session('project_id');
        if (!$project_id) {
            return redirect()->back()->withErrors('Project ID not found');
        }
        $get_project_det = DB::table('projects_details')
                        ->where('id', $project_id)
                        ->first();
        return view('customer.conformation_page', compact('project_id','get_project_det'));
    }

   
    public function customer_dashboard()
    {
        $project_id = session('project_id');
        $get_project_det = DB::table('projects_details')
                            ->where('id', $project_id)
                            ->get();
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

        return response()->json([
            'status' => 'success',
            'message' => $updated ? 'Updated successfully' : 'No change needed'
        ]);
    }

    public function vendor_details(){

        $project_id = session('project_id');
         $get_project_det = DB::table('projects_details')
                            ->where('id', $project_id)
                            ->get();
        $firstProject = $get_project_det->first();

        if (!$firstProject) {
            return redirect()->back()->with('error', 'Project not found.');
        }

        $proj_data = DB::table('project_information')
            ->where('id', $firstProject->project_id)
            ->first();
        return view('customer.vendor_bujet',compact('proj_data'));
    }

    public function vendor_details_data(Request $request)
    {
        $project_id = session('project_id');

        $query = DB::table('projects_details')
            ->join('tenders', 'tenders.project_id', '=', 'projects_details.id')
            ->join('project_likes', 'project_likes.project_id', '=', 'projects_details.id')
            ->where('projects_details.id', $project_id)
            ->select(
                'projects_details.id',
                'projects_details.project_name',
                'projects_details.submission_id',
                'projects_details.budget_range',
                'projects_details.project_location'
                
            )
            ->groupBy(
                'projects_details.id',
                'projects_details.project_name',
                'projects_details.submission_id',
                'projects_details.budget_range',
                'projects_details.project_location'
                
            );

        // Filter: Project Name
        if ($request->filled('project_name')) {
            $query->where('projects_details.project_name', 'like', '%' . $request->project_name . '%');
        }

        return datatables()->of($query)->make(true);
    }

    public function tenderDetails(Request $request)
    {
        $project_id = $request->project_id;

        $tenders = DB::table('tenders')
            ->where('project_id', $project_id)
            ->orderByDesc('id')
            ->get();

        if ($tenders->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No tender data found.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $tenders]);
    }



    public function tenderDocuments(Request $request)
    {
        $project_id = $request->project_id;

        $documents = DB::table('tender_documents')
            ->where('project_id', $project_id)
            ->select('id', 'boq_file', 'vendor_cost','vendor_id')
            ->get()
            ->map(function ($doc) {
                $doc->document_url = asset('storage/' . $doc->boq_file); // ✅ full URL
                $doc->file_name = basename($doc->boq_file);              // optional: just the name
                return $doc;
            });

        return response()->json([
            'status' => 'success',
            'data' => $documents
        ]);
    }


    public function selectVendor(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'vendor_id' => 'required|integer',
            'document_id' => 'required|integer',
        ]);

        DB::table('selected_vendors')->insert([
            'project_id' => $request->project_id,
            'vendor_id' => $request->vendor_id,
            'document_id' => $request->document_id,
            'created_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Vendor selection saved.']);
    }


   public function test(){
    return view('test');
   }


}
