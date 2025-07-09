<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EngginerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CoustomerController;

use App\Http\Controllers\VenderController;

Route::get('/', [CoustomerController::class, 'home'])->name('home');

Route::get('/project', [CoustomerController::class, 'project'])->name('project');

// Route::get('/get-project-types/{constructionTypeId}', [CoustomerController::class, 'getProjectTypes']);
Route::get('/get-subcategories/{projectTypeId}', [CoustomerController::class, 'getSubCategories']);

Route::post('/save-agency-services', [VenderController::class, 'save_agency_services'])->name('save.agency.services');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/service_provider', [VenderController::class, 'service_provider'])->name('service_provider');
Route::get('/about_business', [VenderController::class, 'about_business'])->name('about_business');
 
Route::post('/registerServiceProvider', [VenderController::class, 'registerServiceProvider'])->name('registerServiceProvider');
Route::get('/get-services/{agency_id}', [VenderController::class, 'getServices']);
Route::post('/save-agency-services', [VenderController::class, 'save_agency_services'])->name('save.agency.services');

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->name('admin_dashboard');
    // ->middleware('authCheck');
Route::post('/project-information', [CoustomerController::class, 'store'])->name('projectinfostore');
Route::get('/more-about-project', [CoustomerController::class, 'more_about_project'])->name('more-about-project');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/vendor_approve_form', [AdminController::class, 'vender_approve_form'])->name('vender_approve_form');
Route::get('/vender_approve_data', [AdminController::class, 'vender_approve_data'])->name('vender_approve_data');
Route::get('/vender_reject_data', [AdminController::class, 'vender_reject_data'])->name('vender_reject_data');

Route::post('/admin/vendors/{id}/update-status', [VenderController::class, 'updateStatus'])->name('vendor.updateStatus');
Route::get('/vender/list-of-projects', [VenderController::class, 'showListPage'])->name('projects.list.page');
Route::get('/vender/projects-data', [VenderController::class, 'projectsData']);

Route::get('/vender/like-projects-data', [VenderController::class, 'likeprojectsData']);
Route::get('construction_type', [AdminController::class, 'construction_type'])->name('construction_type');

Route::post('categorystore', [AdminController::class, 'categorystore'])->name('categorystore');
Route::post('rolestore', [AdminController::class, 'rolestore'])->name('rolestore');


Route::post('/category/delete/{id}', [AdminController::class, 'deletecategory'])->name('category.delete');


Route::get('project_type', [AdminController::class, 'project_type'])->name('project_type');
Route::post('/projecttype/store', [AdminController::class, 'storeProjectType'])->name('projecttype.store');
Route::post('/projecttype/delete/{id}', [AdminController::class, 'deleteProjectType'])->name('projecttype.delete');
Route::post('/role/delete/{id}', [AdminController::class, 'deleterole'])->name('role.delete');

Route::get('const_sub_cat', [AdminController::class, 'const_sub_cat'])->name('const_sub_cat');
Route::post('/subcategory/store', [AdminController::class, 'storeSubCategory'])->name('subcategory.store');

Route::get('/get-category-by-project-type/{id}', [AdminController::class, 'getCategoryByProjectType']);
Route::post('/subcategory/delete/{id}', [AdminController::class, 'deleteSubCategory'])->name('subcategory.delete');
Route::get('/project-details/{id}', [CoustomerController::class, 'project_details'])->name('project-details');

Route::get('/project-details', [CoustomerController::class, 'project_details'])->name('project-details');
Route::post('/project-details-store', [CoustomerController::class, 'project_details_store'])->name('project-details-store');
Route::get('/conformation-page', [CoustomerController::class, 'conformation_page'])->name('conformation-page');

Route::get('/customer-details-page', [CoustomerController::class, 'customer_details'])->name('customer_details');
// Route::get('/customer-dashboard', [CoustomerController::class, 'customer_dashboard'])->name('customer.dashboard');
Route::post('/project/update-action', [CoustomerController::class, 'updateAction'])->name('update.project.action');
// web.php
Route::post('/store-project-session', [CoustomerController::class, 'storeProjectSession'])->name('store.project.session');
Route::get('/types_of_agency', [VenderController::class, 'types_of_agency'])->name('types_of_agency');
Route::post('/business-store', [VenderController::class, 'business_store'])->name('business.store');
Route::get('/vendor_confiermetion', [VenderController::class, 'vendor_confiermetion'])->name('vendor_confiermetion');
// Route::get('/vendor_dashboard', [VenderController::class, 'vendor_dashboard'])->name('vendor_dashboard');
// Route::get('/vender/list-of-projects', [VenderController::class, 'showListPage'])->name('projects.list.page');
Route::post('/project-likes', [VenderController::class, 'projectlikes']);
Route::get('/vendor_likes_project', [VenderController::class, 'vendor_likes_project'])->name('vendor_likes_project');

Route::get('/project-details-vendor/{id}', [VenderController::class, 'projectshow']);
// Route::post('/project-information', [CoustomerController::class, 'store'])->name('projectinfostore');
    // Route::get('/project', [CoustomerController::class, 'project'])->name('project');

    Route::middleware(['CheckUserLogin'])->group(function () {
        Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->name('admin_dashboard');
    });
    Route::get('/customer-dashboard', [CoustomerController::class, 'customer_dashboard'])->name('customer.dashboard');
    Route::get('/vendor_dashboard', [VenderController::class, 'vendor_dashboard'])->name('vendor_dashboard');
    Route::get('/engineer_dashboard', [EngginerController::class, 'engineer_dashboard'])->name('engineer_dashboard');
    Route::get('/NewProject', [EngginerController::class, 'allprojectdata'])->name('NewProject');
    Route::get('/NewProjectBoq', [EngginerController::class, 'NewProjectBoq'])->name('NewProjectBoq');

    Route::post('/engineer/project/update-remarks', [EngginerController::class, 'updateRemarks']);
    Route::post('/engineer/project/update-call-response', [EngginerController::class, 'updateCallResponse']);
    Route::post('/engineer/project/upload-boq', [EngginerController::class, 'uploadBOQ']);

    Route::post('/engineer/project/tender', [EngginerController::class, 'storetender']);

    // Add all other protected routes here...
// });

//roles


    Route::get('/addrole', [AdminController::class, 'addrole'])->name('addrole');
    Route::post('/engineer/tender-documents', [VenderController::class, 'storeTenderDocuments']);

    Route::get('/vendor_details', [CoustomerController::class, 'vendor_details'])->name('vendor_details');

    // Route::get('/vendor-details', [CustomerController::class, 'vendor_details'])->name('vendor.details');
    Route::get('/vendor-details/data', [CoustomerController::class, 'vendor_details_data'])->name('vendor.details.data');

    Route::get('/vendor/tender/details', [CoustomerController::class, 'tenderDetails'])->name('vendor.tender.details');
    Route::get('/vendor/tender-documents', [CoustomerController::class, 'tenderDocuments'])->name('vendor.tender.documents');

    Route::post('/vendor/select', [CoustomerController::class, 'selectVendor'])->name('vendor.select');

    Route::get('/proj_const_sub_cat', [AdminController::class, 'proj_const_sub_cat'])->name('proj_const_sub_cat');
    Route::post('/project-cat-type/store', [AdminController::class, 'storeProjectCatType'])->name('project.cat.type.store');
Route::get('/get-project-types-filtered/{id}', [CoustomerController::class, 'getFilteredProjectTypes']);
Route::get('/get-subcategories/{project_type_id}', [CoustomerController::class, 'getSubCategoriesdata']);

Route::get('/get-project-types', [CoustomerController::class, 'getProjectTypes']);
Route::get('/get-sub-categories', [CoustomerController::class, 'getSubCategories']);
