<?php

use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\CategoriesController;
use App\Http\Controllers\dashboard\DepartmentController;
use App\Http\Controllers\dashboard\ImportProductController;
use App\Http\Controllers\dashboard\OrdersController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\ProfileController as AdminProfileController;
use App\Http\Controllers\dashboard\RolesController;
use App\Http\Controllers\dashboard\StoreController;
use App\Http\Controllers\dashboard\UsersController;
use App\Http\Controllers\DashboardController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;



Route::group([
    'middleware'=>['auth:admin'],
    'as'=>'dashboard.',  //pefor(pre) each name route
    'prefix'=>'admin/dashboard', //pefor(pre) each path route
    //'namespace'=>'App\Http\Controllers\dashboard\' the name space for controller if i want to use the old calling way(namecontrooler@namemethod)
],
function(){
    Route::get('/profile/edit',[AdminProfileController::class,'edit'])->name('profile.edit');

    // تحديث بيانات الأدمن
    Route::patch('/profile/admin', [AdminProfileController::class, 'updateAdmin'])->name('profile.update');

    // تحديث بيانات المتجر
    Route::patch('/profile/store/{store}', [AdminProfileController::class, 'updateStore'])->name('store.update');

    // تحديث كلمة المرور
    Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/',[DashboardController::class,'index']);
    Route::get('/categories/trash',[CategoriesController::class,'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'force_delete'])
    ->name('categories.force_delete');
    Route::get('/products/import',[ImportProductController::class,'create'])->name('product.import');
    Route::post('/products/import',[ImportProductController::class,'store'])->name('product.import');
    Route::resource('/categories',CategoriesController::class);
    Route::resource('/products',ProductController::class);
    Route::resource('/departments',DepartmentController::class);
    Route::resource('/stores',StoreController::class);
    Route::resource('/roles',RolesController::class);
    Route::resource('/admins',AdminController::class);
    Route::resource('/users',UsersController::class);
    Route::resource('/orders',OrdersController::class);
    Route::get('/stripe/refresh/{store_id}',[StoreController::class,'stripeRefresh'] )->name('stripe.refresh');
    Route::get('/stripe/return/{store_id}', [StoreController::class,'stripeReturn'])->name('stripe.return');
    Route::get('/stripe/onBoard/{store_id}', [StoreController::class,'dashboardStripeLink'])->name('stripe.dashboard');

});
//second way
// Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function () {

//     Route::get('/',[DashboardController::clasStoreControllers,'index']);

//     Route::resource('/categories',CategoriesController::class);

// });

