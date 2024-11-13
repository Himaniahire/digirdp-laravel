<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/index', function () {
//     return view('index');
// });

// Route::get('/add_form', function () {
//     return view('add_form');
// });
// Route::get('/table', function () {
//     return view('table');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialsController::class);

    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class );
    Route::get('sliders/publish/{id}', [\App\Http\Controllers\Admin\SliderController::class, 'publish'])->name('sliders.publish');
    Route::get('sliders/unpublish/{id}', [\App\Http\Controllers\Admin\SliderController::class, 'unpublish'])->name('sliders.unpublish');

    Route::resource('location', \App\Http\Controllers\Admin\LocationController::class );

    Route::resource('rdp', \App\Http\Controllers\Admin\WindowsRDPController::class );
    Route::get('rdp/publish/{id}', [\App\Http\Controllers\Admin\WindowsRDPController::class, 'publish'])->name('rdp.publish');
    Route::get('rdp/unpublish/{id}', [\App\Http\Controllers\Admin\WindowsRDPController::class, 'unpublish'])->name('rdp.unpublish');
    Route::get('rdp/duplicate/{id}', [\App\Http\Controllers\Admin\WindowsRDPController::class, 'duplicate'])->name('rdp.duplicate');

    Route::resource('offer', \App\Http\Controllers\Admin\OfferController::class );
    Route::get('offer/publish/{id}', [\App\Http\Controllers\Admin\OfferController::class, 'publish'])->name('offer.publish');
    Route::get('offer/unpublish/{id}', [\App\Http\Controllers\Admin\OfferController::class, 'unpublish'])->name('offer.unpublish');

    Route::resource('vps', \App\Http\Controllers\Admin\VPSController::class );
    Route::get('vps/publish/{id}', [\App\Http\Controllers\Admin\VPSController::class, 'publish'])->name('vps.publish');
    Route::get('vps/unpublish/{id}', [\App\Http\Controllers\Admin\VPSController::class, 'unpublish'])->name('vps.unpublish');
    Route::get('vps/duplicate/{id}', [\App\Http\Controllers\Admin\VPSController::class, 'duplicate'])->name('vps.duplicate');

    Route::resource('hosting', \App\Http\Controllers\HostingController::class );
    Route::get('hosting/publish/{id}', [\App\Http\Controllers\HostingController::class, 'publish'])->name('hosting.publish');
    Route::get('hosting/unpublish/{id}', [\App\Http\Controllers\HostingController::class, 'unpublish'])->name('hosting.unpublish');
    Route::get('hosting/duplicate/{id}', [\App\Http\Controllers\HostingController::class, 'duplicate'])->name('hosting.duplicate');


    Route::resource('dedicated', \App\Http\Controllers\Admin\DedicatedController::class );
    Route::get('dedicated/publish/{id}', [\App\Http\Controllers\Admin\DedicatedController::class, 'publish'])->name('dedicated.publish');
    Route::get('dedicated/unpublish/{id}', [\App\Http\Controllers\Admin\DedicatedController::class, 'unpublish'])->name('dedicated.unpublish');
    Route::get('dedicated/duplicate/{id}', [\App\Http\Controllers\Admin\DedicatedController::class, 'duplicate'])->name('dedicated.duplicate');

    Route::resource('user', \App\Http\Controllers\Admin\UserAdminController::class );
    Route::get('user-status', [\App\Http\Controllers\Admin\UserAdminController::class,'user_status'])->name('user.status');

    Route::resource('dedicatedplan', \App\Http\Controllers\Admin\DedicatedPlanController::class);
    Route::get('dedicatedplan/create/{branch_id}', [\App\Http\Controllers\Admin\DedicatedPlanController::class, 'createByDedicated'])->name('dedicatedplan.createByDedicated');
    Route::get('dedicatedplan/publish/{id}', [\App\Http\Controllers\Admin\DedicatedPlanController::class, 'publish'])->name('dedicatedplan.publish');
    Route::get('dedicatedplan/unpublish/{id}', [\App\Http\Controllers\Admin\DedicatedPlanController::class, 'unpublish'])->name('dedicatedplan.unpublish');
    Route::get('dedicatedplan/duplicate/{id}', [\App\Http\Controllers\Admin\DedicatedPlanController::class, 'duplicate'])->name('dedicatedplan.duplicate');

    Route::resource('rdplocationplan', \App\Http\Controllers\RDPByLocationPlanController::class);
    Route::get('rdplocationplan/create/{branch_id}', [\App\Http\Controllers\RDPByLocationPlanController::class, 'createByDedicated'])->name('rdplocationplan.createByDedicated');
    Route::get('rdplocationplan/publish/{id}', [\App\Http\Controllers\RDPByLocationPlanController::class, 'publish'])->name('rdplocationplan.publish');
    Route::get('rdplocationplan/unpublish/{id}', [\App\Http\Controllers\RDPByLocationPlanController::class, 'unpublish'])->name('rdplocationplan.unpublish');
    Route::get('rdplocationplan/duplicate/{id}', [\App\Http\Controllers\RDPByLocationPlanController::class, 'duplicate'])->name('rdplocationplan.duplicate');

    Route::resource('rdplocation', \App\Http\Controllers\RDPByLocationController::class);
    Route::get('rdplocation/publish/{id}', [\App\Http\Controllers\RDPByLocationController::class, 'publish'])->name('rdplocation.publish');
    Route::get('rdplocation/unpublish/{id}', [\App\Http\Controllers\RDPByLocationController::class, 'unpublish'])->name('rdplocation.unpublish');
    Route::get('rdplocation/duplicate/{id}', [\App\Http\Controllers\RDPByLocationController::class, 'duplicate'])->name('rdplocation.duplicate');



    Route::resource('policies', \App\Http\Controllers\Policies::class);

    Route::resource('vpsplan', \App\Http\Controllers\Admin\VPSPlanController::class);
    Route::get('vpsplan/create/{branch_id}', [\App\Http\Controllers\Admin\VPSPlanController::class, 'createByDedicated'])->name('vpsplan.createByDedicated');
    Route::get('vpsplan/publish/{id}', [\App\Http\Controllers\Admin\VPSPlanController::class, 'publish'])->name('vpsplan.publish');
    Route::get('vpsplan/unpublish/{id}', [\App\Http\Controllers\Admin\VPSPlanController::class, 'unpublish'])->name('vpsplan.unpublish');
    Route::get('vpsplan/duplicate/{id}', [\App\Http\Controllers\Admin\VPSPlanController::class, 'duplicate'])->name('vpsplan.duplicate');

    Route::resource('hostingplan', \App\Http\Controllers\HostingPlanController::class);
    Route::get('hostingplan/create/{branch_id}', [\App\Http\Controllers\HostingPlanController::class, 'createByDedicated'])->name('hostingplan.createByDedicated');
    Route::get('hostingplan/publish/{id}', [\App\Http\Controllers\HostingPlanController::class, 'publish'])->name('hostingplan.publish');
    Route::get('hostingplan/unpublish/{id}', [\App\Http\Controllers\HostingPlanController::class, 'unpublish'])->name('hostingplan.unpublish');
    Route::get('hostingplan/duplicate/{id}', [\App\Http\Controllers\HostingPlanController::class, 'duplicate'])->name('hostingplan.duplicate');

    Route::resource('rdpplan', \App\Http\Controllers\Admin\RDPPlanController::class);
    Route::get('rdpplan/create/{branch_id}', [\App\Http\Controllers\Admin\RDPPlanController::class, 'createByDedicated'])->name('rdpplan.createByDedicated');
    Route::get('rdpplan/publish/{id}', [\App\Http\Controllers\Admin\RDPPlanController::class, 'publish'])->name('rdpplan.publish');
    Route::get('rdpplan/unpublish/{id}', [\App\Http\Controllers\Admin\RDPPlanController::class, 'unpublish'])->name('rdpplan.unpublish');
    Route::get('rdpplan/duplicate/{id}', [\App\Http\Controllers\Admin\RDPPlanController::class, 'duplicate'])->name('rdpplan.duplicate');

    Route::resource('about', \App\Http\Controllers\About::class);
    Route::resource('configuration', \App\Http\Controllers\Configuration::class);

    Route::resource('/', \App\Http\Controllers\Admin\DashboardController::class);

    Route::resource('faq', \App\Http\Controllers\Admin\FAQController::class );
    //Route::resource('category', FAQController::class );
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class );
    Route::get('blog/delete', [\App\Http\Controllers\Admin\BlogController::class ,'blog_delete'])->name('blog.delete');
    Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class );
    Route::get('category-status', [\App\Http\Controllers\Admin\CategoryController::class,'status_update'])->name('category.status.change');
    Route::get('blogs-status', [\App\Http\Controllers\Admin\BlogController::class,'status_update'])->name('blog.status.change');

    Route::get('features', [\App\Http\Controllers\Admin\FeaturesController::class, 'index'])->name('features.index');
    Route::get('features/create', [\App\Http\Controllers\Admin\FeaturesController::class, 'create'])->name('features.create');


    Route::get('features/{id}', [\App\Http\Controllers\Admin\FeaturesController::class, 'show'])->name('features.show');

    Route::get('features/{id}/edit', [\App\Http\Controllers\Admin\FeaturesController::class, 'edit'])->name('features.edit');

    Route::post('features', [\App\Http\Controllers\Admin\FeaturesController::class, 'store'])->name('features.store');

    Route::delete('features/{id}', [\App\Http\Controllers\Admin\FeaturesController::class, 'destroy'])->name('features.destroy');

    Route::put('features/{id}', [\App\Http\Controllers\Admin\FeaturesController::class, 'update'])->name('features.update');
