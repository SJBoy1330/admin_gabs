<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserRoleAccess;
use App\Http\Middleware\DashboardRoleAccess;

use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TableManagement;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\CmsController;
use Maatwebsite\Excel\Facades\Excel;

// AUTH PROSES
Route::get('/', function () {
    return redirect('/admin');
});



// Halaman login hanya bisa diakses kalau BELUM login
Route::middleware(UserRoleAccess::class)->group(function () {
    // GET METHOD
    Route::get('/admin', [AuthController::class, 'index'])->name('login');

    // POST METHOD
    Route::post('/login-proses', [AuthController::class, 'loginProses'])->name('login.process');
    Route::post('/register-proses', [AuthController::class, 'registerProses'])->name('register.process');
});

// Halaman dashboard hanya bisa diakses kalau SUDAH login
Route::middleware(DashboardRoleAccess::class)->group(function () {
    // GET METHOD (VIEW)

    // DASHBOARD CONTROLLER
    Route::controller(DashboardController::class)->group(function () {
        // DASHBOARD
        Route::get('/dashboard', 'index')->name('dashboard');
        // PROFILE
        Route::get('/profile', 'profile')->name('admin.profile');
        // CONTACT
        Route::get('/list/contact', 'contact')->name('list.contact');
    });
     // SETTING CONTROLLER
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    // MASTER CONTROLLER
    Route::controller(MasterController::class)->group(function () {
        Route::get('/master/user', 'user')->name('master.user');
        Route::get('/master/type', 'type')->name('master.type');
        Route::get('/master/location', 'location')->name('master.location');
        Route::get('/master/unit', 'unit')->name('master.unit');
        Route::get('/master/facility', 'facility')->name('master.facility');
    });
    // CMS CONTROLLER
    Route::controller(CmsController::class)->group(function () {
        Route::get('/cms/banner', 'banner')->name('cms.banner');
        Route::get('/cms/project', 'project')->name('cms.project');
        Route::get('/cms/article', 'article')->name('cms.article');
        Route::get('/cms/about', 'about')->name('cms.about');
        Route::get('/cms/project/gallery', 'gallery');
        Route::get('/cms/project/gallery/{id}', 'gallery')->name('cms.project.gallery');
    });


    


    //  POST METHOD

    // SETTING
    Route::post('/setting/logo', [SettingController::class, 'updateLogo'])->name('setting.logo');
    Route::post('/setting/seo', [SettingController::class, 'updateSeo'])->name('setting.seo');
    Route::post('/setting/sosmed', [SettingController::class, 'setupSosmed'])->name('setting.sosmed');
    Route::post('/setting/insert/sosmed', [SettingController::class, 'insert_sosmed'])->name('insert.sosmed');
    Route::post('/setting/update/sosmed', [SettingController::class, 'update_sosmed'])->name('update.sosmed');
    
    // DASHBOARD
    Route::controller(DashboardController::class)->group(function () {
         // PROFILE
        Route::post('/dashboard/updateEmail', 'updateEmail')->name('email.update');
        Route::post('/dashboard/updatePassword', 'updatePassword')->name('password.update');
        Route::post('/dashboard/accountDeactivated', 'accountDeactivated')->name('account.deactivated');
        Route::post('/dashboard/updateProfile', 'updateProfile')->name('admin.profile.update');
    });
  
    // DATATABLE
    Route::controller(TableManagement::class)->group(function () {
        // MASTER
        Route::post('/table/user', 'table_user')->name('table.user');
        // CONTACT
        Route::post('/table/contact', 'table_contact')->name('table.contact');
        // CMS
        Route::post('/table/banner', 'table_banner')->name('table.banner');
        Route::post('/table/article', 'table_article')->name('table.article');
        Route::post('/table/project', 'table_project')->name('table.project');
        Route::post('/table/unit', 'table_unit')->name('table.unit');
        Route::post('/table/type', 'table_type')->name('table.type');
        Route::post('/table/location', 'table_location')->name('table.location');
        Route::post('/table/facility', 'table_facility')->name('table.facility');
    });
    // MASTER CONTROLLER
    Route::controller(MasterController::class)->group(function () {
        // USER
        Route::post('/master/user/update', 'update_user')->name('update.user');
        Route::post('/master/user/insert', 'insert_user')->name('insert.user');
          // master unit
        Route::post('/master/unit/update', 'update_unit')->name('update.unit');
        Route::post('/master/unit/insert', 'insert_unit')->name('insert.unit');
         // master TYPE
        Route::post('/master/type/update', 'update_type')->name('update.type');
        Route::post('/master/type/insert', 'insert_type')->name('insert.type');
         // master FACILITY
        Route::post('/master/facility/update', 'update_facility')->name('update.facility');
        Route::post('/master/facility/insert', 'insert_facility')->name('insert.facility');
        Route::post('/modal_facility','modal_facility')->name('modal.facility');
         // master location
        Route::post('/master/location/update', 'update_location')->name('update.location');
        Route::post('/master/location/insert', 'insert_location')->name('insert.location');
       
    });
    // CMS CONTROLLER
    Route::controller(CmsController::class)->group(function () {
         // CMS BANNER
        Route::post('/cms/banner/update', 'update_banner')->name('update.banner');
        Route::post('/cms/banner/insert', 'insert_banner')->name('insert.banner');
        // CMS ARTICLE
        Route::post('/cms/article/update', 'update_article')->name('update.article');
        Route::post('/cms/article/insert', 'insert_article')->name('insert.article');
        // CMS PROJECT
        Route::post('/cms/project/update', 'update_project')->name('update.project');
        Route::post('/cms/project/insert', 'insert_project')->name('insert.project');
         // CMS GALLERY
        Route::post('/cms/gallery/update', 'update_gallery')->name('update.gallery');
        Route::post('/cms/gallery/insert', 'insert_gallery')->name('insert.gallery');
        // CMS ABOUT
        Route::post('/cms/about_1/update', 'update_about_1')->name('update.about_1');
        Route::post('/cms/about_2/update', 'update_about_2')->name('update.about_2');

        Route::post('/modal_banner','modal_banner')->name('modal.banner');
        Route::post('/modal_project','modal_project')->name('modal.project');
        Route::post('/modal_gallery','modal_gallery')->name('modal.gallery');
        Route::post('/modal_article','modal_article')->name('modal.article');
    });


   

    // AJAX
    
    // DATATABLE

    // GLOBAL FUNCTION
    Route::post('/switch/{db?}', [SettingController::class, 'switch']);
    Route::post('/delete', [SettingController::class, 'hapusdata']);
    Route::post('/single/{db?}/{id?}', [SettingController::class, 'single']);
    
});


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');