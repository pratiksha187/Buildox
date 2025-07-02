<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetails;
use Illuminate\Support\Facades\DB;
use App\Models\BOQEntry;
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
                    ->select(
                        'project_information.*',
                        'projects_details.*'
                    )
                    ->get();

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

        $project->save(); // 🛠️ This line is necessary!

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
            'project_id' => 'required',
            'files' => 'required',
            'files.*' => 'file|mimes:xls,xlsx,csv|max:20480',
        ]);

        $file = $request->file('files')[0];

        $data = Excel::toArray([], $file);
        $rows = $data[0]; // First sheet

        foreach (array_slice($rows, 1) as $row) {
            if (!empty($row[0])) {
                BOQEntry::create([
                    'project_id' => $request->project_id,
                    'item' => $row[0] ?? null
                ]);
            }
        }

        return response()->json(['message' => 'BOQ imported successfully!']);
    }

}
