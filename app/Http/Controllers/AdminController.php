<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessRegistration;
use Illuminate\Support\Facades\DB;


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

    public function construction_type() {
        $categories = DB::table('categories')->orderBy('id', 'asc')->get();
        return view('admin.construction_type', compact('categories'));
    }


    public function categorystore(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255'
        ]);

        $categoryName = $request->input('category');

        // Insert into DB using Query Builder and get inserted ID
        $categoryId = DB::table('categories')->insertGetId([
            'name' => $categoryName,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Retrieve the newly added category
        $newCategory = DB::table('categories')->find($categoryId);

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully!',
            'category' => [
                'id' => $newCategory->id,
                'name' => $newCategory->name,
            ]
        ]);
    }

    public function deletecategory($id)
    {
        DB::table('categories')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }

   
    public function project_type() {
        $categories = DB::table('categories')->orderBy('id', 'asc')->get();

        $projecttypes = DB::table('project_types')
            ->join('categories', 'project_types.category_id', '=', 'categories.id')
            ->select('project_types.id', 'project_types.name as project_name', 'categories.name as category_name')
            ->orderBy('project_types.id', 'asc')
            ->get();

        return view('admin.project_type', compact('categories', 'projecttypes'));
    }


    public function storeProjectType(Request $request)
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'projecttype' => 'required|string|max:255'
        ]);

       $id = DB::table('project_types')->insertGetId([
            'category_id' => $request->category,
            'name' => $request->projecttype,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project type added successfully.',
            'id' => $id
        ]);

    }

    public function deleteProjectType($id)
    {
        DB::table('project_types')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project type deleted successfully.'
        ]);
    }


    public function const_sub_cat() {
    $project_types = DB::table('project_types')->orderBy('id', 'asc')->get();

    $subcategories = DB::table('construction_sub_categories')
        ->join('categories', 'construction_sub_categories.category_id', '=', 'categories.id')
        ->join('project_types', 'construction_sub_categories.project_type_id', '=', 'project_types.id')
        ->select(
            'construction_sub_categories.id',
            'construction_sub_categories.name as subcategory_name',
            'categories.name as category_name',
            'project_types.name as project_type_name'
        )
        ->orderBy('construction_sub_categories.id', 'asc')
        ->get();

    return view('admin.const_sub_cat', compact('project_types', 'subcategories'));
}

// This endpoint will return category by project_type
public function getCategoryByProjectType($projectTypeId) {
    $category = DB::table('project_types')
        ->join('categories', 'project_types.category_id', '=', 'categories.id')
        ->where('project_types.id', $projectTypeId)
        ->select('categories.id', 'categories.name')
        ->first();

    return response()->json($category);
}

public function storeSubCategory(Request $request)
{
    $request->validate([
        'project_type' => 'required|exists:project_types,id',
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
    ]);

    $id = DB::table('construction_sub_categories')->insertGetId([
        'project_type_id' => $request->project_type,
        'category_id' => $request->category_id,
        'name' => $request->name,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $projectType = DB::table('project_types')->find($request->project_type);
    $category = DB::table('categories')->find($request->category_id);

    return response()->json([
        'success' => true,
        'message' => 'Sub Category added successfully.',
        'id' => $id,
        'category' => $category->name,
        'project_type' => $projectType->name,
        'name' => $request->name
    ]);
}

public function deleteSubCategory($id)
{
    DB::table('construction_sub_categories')->where('id', $id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Subcategory deleted successfully.'
    ]);
}

}
