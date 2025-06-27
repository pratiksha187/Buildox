<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CoustomerController;

use App\Http\Controllers\VenderController;

Route::get('/', [CoustomerController::class, 'home'])->name('home');

Route::get('/project', [CoustomerController::class, 'project'])->name('project');
Route::get('/service-provider', [VenderController::class, 'service_provider'])->name('service-provider');

Route::get('/get-project-types/{constructionTypeId}', [CoustomerController::class, 'getProjectTypes']);
Route::get('/get-subcategories/{projectTypeId}', [CoustomerController::class, 'getSubCategories']);


Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])
    ->name('admin_dashboard') 
    ->middleware('authCheck');
Route::post('/project-information', [CoustomerController::class, 'store'])->name('projectinfostore');
Route::get('/more-about-project', [CoustomerController::class, 'more_about_project'])->name('more-about-project');

// Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->middleware('authCheck');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/vendor_approve_form', [AdminController::class, 'vender_approve_form'])->name('vender_approve_form');
Route::get('/vender_approve_data', [AdminController::class, 'vender_approve_data'])->name('vender_approve_data');
Route::get('/vender_reject_data', [AdminController::class, 'vender_reject_data'])->name('vender_reject_data');

Route::post('/admin/vendors/{id}/update-status', [VenderController::class, 'updateStatus'])->name('vendor.updateStatus');
Route::get('/vender/list-of-projects', [VenderController::class, 'showListPage'])->name('projects.list.page');
Route::get('/vender/projects-data', [VenderController::class, 'projectsData']);
Route::get('construction_type', [AdminController::class, 'construction_type'])->name('construction_type');

Route::post('categorystore', [AdminController::class, 'categorystore'])->name('categorystore');
Route::post('/category/delete/{id}', [AdminController::class, 'deletecategory'])->name('category.delete');


Route::get('project_type', [AdminController::class, 'project_type'])->name('project_type');
Route::post('/projecttype/store', [AdminController::class, 'storeProjectType'])->name('projecttype.store');
Route::post('/projecttype/delete/{id}', [AdminController::class, 'deleteProjectType'])->name('projecttype.delete');

// Route::get('const_sub_cat', [AdminController::class, 'const_sub_cat'])->name('const_sub_cat');
// Route::post('/subcategory/store', [AdminController::class, 'storeSubCategory'])->name('subcategory.store');

Route::get('const_sub_cat', [AdminController::class, 'const_sub_cat'])->name('const_sub_cat');
Route::post('/subcategory/store', [AdminController::class, 'storeSubCategory'])->name('subcategory.store');

Route::get('/get-category-by-project-type/{id}', [AdminController::class, 'getCategoryByProjectType']);
Route::post('/subcategory/delete/{id}', [AdminController::class, 'deleteSubCategory'])->name('subcategory.delete');

