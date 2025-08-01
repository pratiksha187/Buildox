<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetails;
use Illuminate\Support\Facades\DB;
use App\Models\BOQEntry;
use App\Models\Tender;
use Maatwebsite\Excel\Facades\Excel;



class EngginerController extends Controller
{
    public function engineer_dashboard(){
        return view('engg.engg_dashboard');
    }

    public function allprojectdata()
    {
        $projects = DB::table('projects_details')
            ->join('project_information', 'projects_details.project_id', '=', 'project_information.id')
            ->select('project_information.*', 'projects_details.*')
            ->orderBy('project_information.id', 'desc')
            ->paginate(10); // Adjust the number as needed
//             echo"<pre>";
// print_r($projects);die;
        return view('engg.allprojectdata', compact('projects'));
    }



    public function NewProjectBoq(){
        $projects = DB::table('projects_details')
                    ->join('project_information', 'projects_details.project_id', '=', 'project_information.id')
                    ->select(
                        'project_information.*',
                        'projects_details.*'
                    )
                    ->get();
//                      echo"<pre>";
// print_r($projects);die;
        return view('engg.projectboq', compact('projects'));

    }

   public function updateRemarks(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'engg_decription' => 'nullable|string|max:1000'
        ]);

        $project = ProjectDetails::findOrFail($request->id);
        $project->engg_decription = $request->engg_decription;

        $project->save(); 

        return response()->json(['message' => 'Remarks updated']);
    }


    public function updateCallResponse(Request $request){
        $request->validate([
            'id' => 'required',
            'call_status' => 'required',
            'call_remarks' => 'nullable|string',
        ]);

        $CallResponse = ProjectDetails::findOrFail($request->id);
        $CallResponse->call_status = $request->call_status;
        $CallResponse->call_remarks = $request->call_remarks;
        $CallResponse->save(); 
        return response()->json(['message' => 'CallResponse updated']);

    }
public function uploadBOQ(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects_details,id',
        'files' => 'required|array',
        'files.*' => 'file|mimes:xls,xlsx,csv|max:20480',
    ]);

    $file = $request->file('files')[0]; 
    $filePath = $file->store('boq_files', 'public'); 

    $get_project_info_id = DB::table('projects_details')
        ->where('id', $request->project_id)
        ->first(); // use first() instead of get()

    DB::table('projects_details')
        ->where('id', $request->project_id)
        ->update(['boq_status' => 1]); 

    DB::table('project_information') // fixed table name
        ->where('id', $get_project_info_id->project_id)
        ->update(['boqFile' => $filePath]); 

    return response()->json(['message' => 'BOQ file uploaded successfully!', 'path' => $filePath]);
}

    public function storetender(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'tender_value' => 'nullable|numeric',
            'product_category' => 'nullable|string',
            'sub_category' => 'nullable|string',
            'contract_type' => 'nullable|string',
            'bid_validity_days' => 'nullable|integer',
            'period_of_work_days' => 'nullable|integer',
            'location' => 'nullable|string',
            'pincode' => 'nullable|string',
            'published_date' => 'nullable|date',
            'bid_opening_date' => 'nullable|date',
            'bid_submission_start' => 'nullable|date',
            'bid_submission_end' => 'nullable|date',
        ]);

        Tender::create($validated);

        DB::table('projects_details')
            ->where('id', $request->project_id)
            ->update(['tender_status' => 1]); 

        return response()->json(['success' => true, 'message' => 'Tender saved successfully.']);
    }

}
