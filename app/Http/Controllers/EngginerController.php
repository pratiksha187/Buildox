<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetails;
use Illuminate\Support\Facades\DB;

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



}
