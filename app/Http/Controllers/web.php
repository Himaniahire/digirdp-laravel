<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\FeaturesController;
use App\Http\Controllers\Admin\WindowsRDPController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\DedicatedController;
use App\Http\Controllers\Admin\VPSController;
use App\Http\Controllers\Admin\DedicatedPlanController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\RDPByLocationPlanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PublicController::class, 'index']);



Auth::routes(['register'=> false]);
//Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [PublicController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PublicController::class, 'blog_single'])->name('blog.single.view');

Route::middleware(['maintenance'])->prefix(env('MAINTENANCE_URL').'/{password}')->group(function() {
    Route::get('/', [SetupController::class, 'getMaintenance']);
    Route::post('/', [SetupController::class, 'postMaintenance'])->name('postmn');
});


Route::prefix('admin')->group(function() {
    Route::resource('testimonials', TestimonialsController::class);

    Route::resource('sliders', SliderController::class );
    Route::get('sliders/publish/{id}', [SliderController::class, 'publish'])->name('sliders.publish');
    Route::get('sliders/unpublish/{id}', [SliderController::class, 'unpublish'])->name('sliders.unpublish');

    Route::resource('location', LocationController::class );

    Route::resource('rdp', WindowsRDPController::class );
    Route::get('rdp/publish/{id}', [WindowsRDPController::class, 'publish'])->name('rdp.publish');
    Route::get('rdp/unpublish/{id}', [WindowsRDPController::class, 'unpublish'])->name('rdp.unpublish');
    Route::get('rdp/duplicate/{id}', [WindowsRDPController::class, 'duplicate'])->name('rdp.duplicate');

    Route::resource('offer', OfferController::class );
    Route::get('offer/publish/{id}', [OfferController::class, 'publish'])->name('offer.publish');
    Route::get('offer/unpublish/{id}', [OfferController::class, 'unpublish'])->name('offer.unpublish');

    Route::resource('vps', VPSController::class );
    Route::get('vps/publish/{id}', [VPSController::class, 'publish'])->name('vps.publish');
    Route::get('vps/unpublish/{id}', [VPSController::class, 'unpublish'])->name('vps.unpublish');
    Route::get('vps/duplicate/{id}', [VPSController::class, 'duplicate'])->name('vps.duplicate');

    Route::resource('hosting', \App\Http\Controllers\HostingController::class );
    Route::get('hosting/publish/{id}', [\App\Http\Controllers\HostingController::class, 'publish'])->name('hosting.publish');
    Route::get('hosting/unpublish/{id}', [\App\Http\Controllers\HostingController::class, 'unpublish'])->name('hosting.unpublish');
    Route::get('hosting/duplicate/{id}', [\App\Http\Controllers\HostingController::class, 'duplicate'])->name('hosting.duplicate');

    Route::resource('rdplocation', \App\Http\Controllers\RDPByLocationController::class );
    Route::get('rdplocation/publish/{id}', [\App\Http\Controllers\RDPByLocationController::class, 'publish'])->name('rdplocation.publish');
    Route::get('rdplocation/unpublish/{id}', [\App\Http\Controllers\RDPByLocationController::class, 'unpublish'])->name('rdplocation.unpublish');
    Route::get('rdplocation/duplicate/{id}', [\App\Http\Controllers\RDPByLocationController::class, 'duplicate'])->name('rdplocation.duplicate');


    Route::resource('dedicated', DedicatedController::class );
    Route::get('dedicated/publish/{id}', [DedicatedController::class, 'publish'])->name('dedicated.publish');
    Route::get('dedicated/unpublish/{id}', [DedicatedController::class, 'unpublish'])->name('dedicated.unpublish');
    Route::get('dedicated/duplicate/{id}', [DedicatedController::class, 'duplicate'])->name('dedicated.duplicate');

    Route::resource('user', \App\Http\Controllers\Admin\UserAdminController::class );
    Route::get('user-status', [UserAdminController::class,'user_status'])->name('user.status');

    Route::resource('dedicatedplan', DedicatedPlanController::class);
    Route::get('dedicatedplan/create/{branch_id}', [DedicatedPlanController::class, 'createByDedicated'])->name('dedicatedplan.createByDedicated');
    Route::get('dedicatedplan/publish/{id}', [DedicatedPlanController::class, 'publish'])->name('dedicatedplan.publish');
    Route::get('dedicatedplan/unpublish/{id}', [DedicatedPlanController::class, 'unpublish'])->name('dedicatedplan.unpublish');
    Route::get('dedicatedplan/duplicate/{id}', [DedicatedPlanController::class, 'duplicate'])->name('dedicatedplan.duplicate');

    Route::resource('rdplocationplan', RDPByLocationPlanController::class);
    Route::get('rdplocationplan/create/{branch_id}', [RDPByLocationPlanController::class, 'createByDedicated'])->name('rdplocationplan.createByDedicated');
    Route::get('rdplocationplan/publish/{id}', [RDPByLocationPlanController::class, 'publish'])->name('rdplocationplan.publish');
    Route::get('rdplocationplan/unpublish/{id}', [RDPByLocationPlanController::class, 'unpublish'])->name('rdplocationplan.unpublish');
    Route::get('rdplocationplan/duplicate/{id}', [RDPByLocationPlanController::class, 'duplicate'])->name('rdplocationplan.duplicate');


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

    Route::resource('dashboard', \App\Http\Controllers\Admin\DashboardController::class);

    Route::resource('faq', FAQController::class );
    //Route::resource('category', FAQController::class );
    Route::resource('blogs', BlogController::class );
    Route::get('blog/delete', [BlogController::class ,'blog_delete'])->name('blog.delete');
    Route::resource('category', CategoryController::class );
    Route::get('category-status', [CategoryController::class,'status_update'])->name('category.status.change');
    Route::get('blogs-status', [BlogController::class,'status_update'])->name('blog.status.change');

    Route::get('features', [FeaturesController::class, 'index'])->name('features.index');
    Route::get('features/create', [FeaturesController::class, 'create'])->name('features.create');


    Route::get('features/{id}', [FeaturesController::class, 'show'])->name('features.show');

    Route::get('features/{id}/edit', [FeaturesController::class, 'edit'])->name('features.edit');

    Route::post('features', [FeaturesController::class, 'store'])->name('features.store');

    Route::delete('features/{id}', [FeaturesController::class, 'destroy'])->name('features.destroy');

    Route::put('features/{id}', [FeaturesController::class, 'update'])->name('features.update');

});



Route::get('contact', [PublicController::class, 'contact'])->name('contact');
Route::get('knowledgebase', [PublicController::class, 'faq'])->name('faqs');

Route::get('rdp-plan/{plan_url}', [PublicController::class, 'rdpPlans'])->name('rdpPlan');
Route::get('cloud-vps-plan/{plan_url}', [PublicController::class, 'cloudVPSPlan'])->name('cloudVpsPlan');
Route::get('dedicated-plan/{plan_url}', [PublicController::class, 'dedicatedPlan'])->name('dedicatedPlan');
Route::get('rdp-by-location-plan/{plan_url}', [PublicController::class, 'rdpByLocationPlan'])->name('rdpByLocationPlan');


Route::get('about', [PublicController::class, 'about'])->name('publicAbout');

Route::get('policy/{policyType}', [PublicController::class, 'privacy'])->name('privacyPolicies');

Route::post('send/message', [PublicController::class, 'saveMessage']);

Route::get('/{category_type}', [PublicController::class, 'category']);

Route::get('/view/offers', [PublicController::class, 'offers']);
