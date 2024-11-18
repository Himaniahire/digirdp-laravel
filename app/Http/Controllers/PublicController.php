<?php

namespace App\Http\Controllers;

use App\Models\Dedicated;
use App\Models\FAQ;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Slider;
use App\Models\RDPByLocation;
use App\Models\RDPPlan;
use App\Models\Blog;
use App\Models\Testimonials;
use App\Models\VPS;
use App\Models\WindowsRdp;
use \App\Models\About;
use \App\Models\Post;
use \App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Parsedown;
use Session;

class PublicController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function index(Request $request)
    {
        $windowsRDP = $this->cachedQuerySetProducts('windowsRDP','windows_rdps');
        $cloudVPS = $this->cachedQuerySetProducts('cloudVPS','v_p_s');
        $rdplocation =  $this->cachedQuerySetProducts('rdplocation','r_d_p_by_locations');
        $dedicatedServer = $this->cachedQuerySetProducts('dedicatedServer','dedicateds');

        $rdpPlan = $this->cachedQuerySetPlans('rdpPlan','r_d_p_plans');
        $dedicatedPlans = $this->cachedQuerySetPlans('dedicatedPlans','dedicated_plans');
        $cloudPlan = $this->cachedQuerySetPlans('cloudPlan','v_p_s_plans');
        $rdpLocationPlan = $this->cachedQuerySetPlans('rdpLocationPlan','r_d_p_by_location_plans');

        $planCount = $this->planCount();
        $configuration = $this->DBconfiguration();
        $offers = $this->DBoffers();
        $faqs = $this->DBfaq();
        $testimonials = $this->DBtestimonials();
        $features_card = $this->DBfeaturesCard();
        $sliders  = $this->DBsliders();

        $description = "DigiRDP provides cheap admin RDP & Shared RDP on cheap prices. Buy Cheap RDP in USA, UK, Netherlands, France & India location on affordable prices.";
        $author = "DigiRDP admin";
        $title = " Buy Cheap RDP - Shared USA/UK/NL RDP @3.99$/M";

        return view('welcome')->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)
            ->with('rdplocation', $rdplocation)
            ->with('rdpLocationPlan', $rdpLocationPlan)
            ->with('offers', $offers)
            ->with('dedicatedServer', $dedicatedServer)
            ->with('rdpPlans', $rdpPlan)
            ->with('dedicatedPlans', $dedicatedPlans)
            ->with('cloudPlan', $cloudPlan)
            ->with('faqs', $faqs)
            ->with('counts', $planCount)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('description', $description)
            ->with('author', $author)->with('title', $title)
            ->with('features_card', $features_card);

    }

    public function forgot_password(Request $request){

         Mail::send('mail', $data, function($message) {
             $message->to('abc@gmail.com', 'Tutorials Point')->subject
                ('Laravel HTML Testing Mail');
             $message->from('xyz@gmail.com','Virat Gandhi');
          });
    }

    public function blog(){

        $windowsRDP = $this->cachedQuerySetProducts('windowsRDP','windows_rdps');
        $cloudVPS = $this->cachedQuerySetProducts('cloudVPS','v_p_s');
        $rdplocation =  $this->cachedQuerySetProducts('rdplocation','r_d_p_by_locations');
        $dedicatedServer = $this->cachedQuerySetProducts('dedicatedServer','dedicateds');

        $planCount = $this->planCount();
        $configuration = $this->DBconfiguration();
        $faqs = $this->DBfaq();
        $testimonials = $this->DBtestimonials();

        $about = cache()->remember('about', now()->addHours(24), function () {
            return About::find(1);
        });

        $description = "Nothing is more frustrating than a remote working solution that is hampered by
                        attacks but fear not because DigiRDP servers are encrypted and fully secured. So, you can enjoy
                        a fully secure data management";
        $author = "DigiRDP admin";
        $title = "Buy Best RDP products";

        return view('blogs')->with('about', $about)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('counts', $planCount)
            ->with('rdplocation', $rdplocation)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('description', $description)->with('faqs', $faqs)
            ->with('author', $author)->with('title', $title);
    }

    public function blog_single($slug){
//        dd($slug);

        $blog = cache()->remember('singleBlog-'.$slug, now()->addHours(24), function () use ($slug) {
            return Post::with(['category','user'])->where('slug',$slug)->first();
        });
        $related_article = cache()->remember('relatedArticle-'.$blog->slug, now()->addHours(24), function () use ($blog) {
            return Post::with(['category','user'])->where('status',1)->where('category_id',$blog->category->id)->limit(8)->get();
        });

        $windowsRDP = $this->cachedQuerySetProducts('windowsRDP','windows_rdps');
        $cloudVPS = $this->cachedQuerySetProducts('cloudVPS','v_p_s');
        $rdplocation =  $this->cachedQuerySetProducts('rdplocation','r_d_p_by_locations');
        $dedicatedServer = $this->cachedQuerySetProducts('dedicatedServer','dedicateds');

        $planCount = $this->planCount();
        $configuration = $this->DBconfiguration();
        $faqs = $this->DBfaq();
        $testimonials = $this->DBtestimonials();
        $about = cache()->remember('about', now()->addHours(24), function () {
            return About::find(1);
        });

        $title = $blog->title;
        $description = $blog->meta_descriptions ?? '';
        $meta_keywords = $blog->meta_keywords ?? '';
        $author = "DigiRDP admin";

        return view('blog-single')->with('about', $about)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('counts', $planCount)
            ->with('rdplocation', $rdplocation)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('description', $description)->with('faqs', $faqs)
            ->with('author', $author)->with('title', $title)->with('meta_keywords', $meta_keywords)->
            with('blog',$blog)->with('related_article',$related_article);
    }

    public function offers()
    {
        $faqs = FAQ::all();
        $windowsRDP = $this->cachedQuerySetProducts('windowsRDP','windows_rdps');
        $cloudVPS = $this->cachedQuerySetProducts('cloudVPS','v_p_s');
        $rdplocation =  $this->cachedQuerySetProducts('rdplocation','r_d_p_by_locations');
        $dedicatedServer = $this->cachedQuerySetProducts('dedicatedServer','dedicateds');

        $planCount = $this->planCount();
        $configuration = $this->DBconfiguration();
        $testimonials = $this->DBtestimonials();
        $offers = cache()->remember('offersAll', now()->addHours(24), function () {
            return DB::table('offers')->where('is_published', 1)->orderBy('created_at', 'desc')->get();
        });

        $title = "Buy Best RDP products";
        $description = "Nothing is more frustrating than a remote working solution that is hampered by
                        attacks but fear not because DigiRDP servers are encrypted and fully secured. So, you can enjoy
                        a fully secure data management";
        $author = "DigiRDP Offers";

        return view('offers')->with('faqs', $faqs)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)
            ->with('offers', $offers)
            ->with('rdplocation', $rdplocation)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('description', $description) ->with('counts', $planCount)
            ->with('author', $author)->with('title', $title);
    }

    public function faq(Request $request)
    {
        $faq_category = DB::table('faq_category')->get();
        $faqs = FAQ::join('faq_category', 'f_a_q_s.category_id', '=', 'faq_category.category_id')->get();

        $windowsRDP = $this->cachedQuerySetProducts('windowsRDP','windows_rdps');
        $cloudVPS = $this->cachedQuerySetProducts('cloudVPS','v_p_s');
        $rdplocation =  $this->cachedQuerySetProducts('rdplocation','r_d_p_by_locations');
        $dedicatedServer = $this->cachedQuerySetProducts('dedicatedServer','dedicateds');

        $planCount = $this->planCount();
        $configuration = $this->DBconfiguration();
        $faqs_demo = $this->DBfaq();
        $testimonials = $this->DBtestimonials();

        $description = "Nothing is more frustrating than a remote working solution that is hampered by
                        attacks but fear not because DigiRDP servers are encrypted and fully secured. So, you can enjoy
                        a fully secure data management";
        $author = "DigiRDP admin";
        $title = "Buy Best RDP products";

        return view('faq')->with('faqs', $faqs)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('rdplocation', $rdplocation)
            ->with('description', $description) ->with('counts', $planCount)
            ->with('author', $author)->with('title', $title)
            ->with('faq_category', $faq_category);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function contact(Request $request)
    {
        $windowsRDP = $this->cachedQuerySetProducts('windowsRDP','windows_rdps');
        $cloudVPS = $this->cachedQuerySetProducts('cloudVPS','v_p_s');
        $rdplocation =  $this->cachedQuerySetProducts('rdplocation','r_d_p_by_locations');
        $dedicatedServer = $this->cachedQuerySetProducts('dedicatedServer','dedicateds');

        $planCount = $this->planCount();
        $configuration = $this->DBconfiguration();
        $faqs = $this->DBfaq();
        $testimonials = $this->DBtestimonials();

        $description = "Nothing is more frustrating than a remote working solution that is hampered by
                        attacks but fear not because DigiRDP servers are encrypted and fully secured. So, you can enjoy
                        a fully secure data management";
        $author = "DigiRDP admin";
        $title = "Buy Best RDP products";

        return view('contact')->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs) ->with('counts', $planCount)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('rdplocation', $rdplocation)
            ->with('description', $description)
            ->with('configuration', $configuration)
            ->with('author', $author)->with('title', $title);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function about(Request $request)
    {
        $windowsRDP = $this->cachedQuerySetProducts('windowsRDP','windows_rdps');
        $cloudVPS = $this->cachedQuerySetProducts('cloudVPS','v_p_s');
        $rdplocation =  $this->cachedQuerySetProducts('rdplocation','r_d_p_by_locations');
        $dedicatedServer = $this->cachedQuerySetProducts('dedicatedServer','dedicateds');

        $planCount = $this->planCount();
        $configuration = $this->DBconfiguration();
        $faqs = $this->DBfaq();
        $testimonials = $this->DBtestimonials();
        $about = cache()->remember('about', now()->addHours(24), function () {
            return About::find(1);
        });

        $title = "Buy Best RDP products";
        $description = "Nothing is more frustrating than a remote working solution that is hampered by
                        attacks but fear not because DigiRDP servers are encrypted and fully secured. So, you can enjoy
                        a fully secure data management";
        $author = "DigiRDP admin";

        return view('about')->with('about', $about)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('counts', $planCount)
            ->with('rdplocation', $rdplocation)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('description', $description)->with('faqs', $faqs)
            ->with('author', $author)->with('title', $title);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveMessage(Request $request)
    {
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();
        $message = new Message();
        $message->name = $request->name;
        $message->subject = $request->subject;
        $message->email = $request->email;
        $message->message = $request->message;
        $status = $message->save();
        if (!$status)
            return redirect("/contact")->with('status', false)->with('message', 'sorry not able to post message')->with('windowsRDP', $windowsRDP)
                ->with('rdplocation', $rdplocation)
                ->with('cloudVPS', $cloudVPS)
                ->with('configuration', $configuration)
                ->with('dedicatedServer', $dedicatedServer);
        return redirect("/contact")->with('status', true)->with('message', 'message saved successfully')->with('windowsRDP', $windowsRDP)
            ->with('rdplocation', $rdplocation)
            ->with('cloudVPS', $cloudVPS)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer);
    }

    /**
     * @param $plan_url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function rdpPlans($plan_url)
    {
        try{
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();
        $author = "DigiRDP admin";
        $planDetails = DB::table('windows_rdps')->where('url_text', $plan_url)->get();
        $configuration->keywords = $planDetails[0]->keyword != "" ? $planDetails[0]->keyword : $configuration->keywords;
        if(!count($planDetails))
            return redirect("/");
        $plans = DB::table('r_d_p_plans')->where('rdp_id', $planDetails[0]->id)->where('is_published', 1)
            ->orderBy('priority', 'desc')->get();


        $features_rdp = DB::table('features_rdp')->get();

        $features_card = DB::table('features_card')
                        ->where('category_id', 1)
                        ->get();


        return view('plans')->with('planDetails', $planDetails[0])
            ->with('plans', $plans)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('rdplocation', $rdplocation)
            ->with('configuration', $configuration)
            ->with('description', $planDetails[0]->description)->with('counts', $planCount)
            ->with('author', $author)->with('title', $planDetails[0]->title)
            ->with('features_rdp', $features_rdp)
            ->with('logo_og', $planDetails[0]->logo)
            ->with('features_card', $features_card);
        }
        catch(\Exception $e){
            return $this->Error404();
        }
    }

    public function hostingPlan($plan_url)
    {
        try{
        $author = "DigiRDP admin";
        $planDetails = DB::table('hostings')->where('url_text', $plan_url)->get();

        if(!count($planDetails))
            return redirect("/");
        $plans = DB::table('hosting_plans')->where('hosting_id', $planDetails[0]->id)->where('is_published', 1)
            ->orderBy('priority', 'desc')->get();
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $configuration->keywords = $planDetails[0]->keyword != "" ? $planDetails[0]->keyword : $configuration->keywords ;
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();
        return view('plans')->with('planDetails', $planDetails[0])
            ->with('plans', $plans)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)
            ->with('rdplocation', $rdplocation)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('configuration', $configuration)
            ->with('description', $planDetails[0]->name)->with('counts', $planCount)
            ->with('author', $author)->with('title', $planDetails[0]->title);
        }
        catch(\Exception $e){
            return $this->Error404();
        }
    }

    public function rdpByLocationPlan($plan_url)
    {

        try{
        $author = "DigiRDP admin";
        $planDetails = DB::table('r_d_p_by_locations')->where('url_text', $plan_url)->get();

        if(!count($planDetails))
            return redirect("/");
        $plans = DB::table('r_d_p_by_location_plans')->where('rdp_id', $planDetails[0]->id)->where('is_published', 1)
            ->orderBy('priority', 'desc')->get();
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $configuration->keywords = $planDetails[0]->keyword != "" ? $planDetails[0]->keyword : $configuration->keywords ;
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();

        $features_rdp = DB::table('features_rdp')->get();

        $features_card = DB::table('features_card')
                        ->where('category_id', 1)
                        ->get();

        return view('plans')->with('planDetails', $planDetails[0])
            ->with('plans', $plans)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)
            ->with('rdplocation', $rdplocation)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('configuration', $configuration)
            ->with('description', $planDetails[0]->description)->with('counts', $planCount)
            ->with('author', $author)->with('title', $planDetails[0]->title)
            ->with('features_rdp', $features_rdp)
            ->with('features_card', $features_card);

        }
        catch(\Exception $e){
            return $this->Error404();
        }
    }

    /**
     * @param $plan_url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cloudVPSPlan($plan_url)
    {
        try{

        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();
        $author = "DigiRDP admin";
        $planDetails = DB::table('v_p_s')->where('url_text', $plan_url)->get();
        $configuration->keywords = $planDetails[0]->keyword != "" ? $planDetails[0]->keyword : $configuration->keywords ;
        if(!count($planDetails))
            return redirect("/");
        $plans = DB::table('v_p_s_plans')->where('vps_id', $planDetails[0]->id)->where('is_published', 1)
            ->orderBy('priority', 'desc')->get();
        $description = "DigiRDP provides cheap linux SSD VPS on affordable prices & you can buy linux SSD VPS for your website on cheap prices @6.99$/M, fast & reliable VPS";


        $features_card = DB::table('features_card')
                        ->where('category_id', 3)
                        ->get();


        return view('plans')->with('planDetails', $planDetails[0])
            ->with('plans', $plans)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)
            ->with('rdplocation', $rdplocation)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('configuration', $configuration)
            ->with('description', $description)->with('counts', $planCount)
            ->with('author', $author)->with('title', $planDetails[0]->title)
            ->with('features_card', $features_card);
        }
        catch(\Exception $e){
            return $this->Error404();
        }
    }

    /**
     * @param $plan_url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dedicatedPlan($plan_url)
    {
        try{
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();

        $author = "DigiRDP admin";
        $planDetails = DB::table('dedicateds')->where('url_text', $plan_url)->get();
        if(!count($planDetails))
            return redirect("/");
        $plans = DB::table('dedicated_plans')->where('dedicated_id', $planDetails[0]->id)->where('is_published', 1)
            ->orderBy('priority', 'desc')->get();
        $configuration->keywords = $planDetails[0]->keyword != "" ? $planDetails[0]->keyword : $configuration->keywords ;

        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $description = "DigiRDP provides cheap Dedicated RDP SSD. Buy Cheap Dedicated RDP in USA, UK, Netherlands, France & India location on affordable prices";

        $features_card = DB::table('features_card')
                        ->where('category_id', 2)
                        ->get();

        return view('plans')->with('planDetails', $planDetails[0])
            ->with('plans', $plans)->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)
            ->with('configuration', $configuration)
            ->with('rdplocation', $rdplocation)
            ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
            ->with('description', $description)->with('counts', $planCount)
            ->with('author', $author)->with('title', $planDetails[0]->title)
            ->with('features_card', $features_card);
        }
        catch(\Exception $e){
            return $this->Error404();
        }
    }

    public function category($category_type)
    {
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();
        $author = "DigiRDP admin";
        $description = "DigiRDP provides cheap Dedicated RDP SSD. Buy Cheap Dedicated RDP in USA, UK, Netherlands, France & India location on affordable prices";
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $category_select = [];
        $category_name = "";
        $category_description = "";
        $url = "";
        switch ($category_type) {
            case "rdp-plan":
                $category_select = $windowsRDP;
                $category_name = "Windows RDP";
                $category_description = "Here for RDP? Look no where else, we will setup Windows RDP tailored
                                to your needs no matter the scale";
                $url = "rdp-plan";
                break;
            case "cloud-vps-plan":
                $category_select = $cloudVPS;
                $category_name = "Cloud VPS";
                $category_description = "Our Cloud VPS service is best suited for any kind of website,
                                production environment or pre-production environment.";
                $url = "cloud-vps-plan";
                break;
            case "dedicated-plan":
                $category_select = $dedicatedServer;
                $category_name = "Dedicated Server";
                $category_description = "With SSD storage, high-memory variants and latest
                                processors, use our servers to get the best performance";
                $url = "dedicated-plan";
                break;
            case "rdp-by-location-plan":
                $category_select = $rdplocation;
                $category_name = "RDP By Location";
                $category_description = "Here for RDP? Look no where else, we will setup Windows RDP tailored
                                to your needs no matter the scale";
                $url = "rdpbylocation-plan";
                break;

            default: return $this->Error404();
        }


        return view('category')
            ->with('category', $category_select)
            ->with('category_name', $category_name)
            ->with('url_text', $url)
            ->with('rdplocation', $rdplocation)
            ->with('category_description', $category_description)
            ->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)
            ->with('dedicatedServer', $dedicatedServer)
            ->with('description', $description)
            ->with('counts', $planCount)
            ->with('author', $author)
            ->with('title', "Windows PLAN");
    }

    public function privacy($policyType)
    {
        $Parsedown = new Parsedown();
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();
        $description = "Nothing is more frustrating than a remote working solution that is hampered by
                        attacks but fear not because DigiRDP servers are encrypted and fully secured. So, you can enjoy
                        a fully secure data management";
        $author = "DigiRDP admin";
        $title = "Buy Best RDP products";
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        switch ($policyType)
        {
            case "privacy":
                $policies = DB::table('policies')->where('type', 'privacy_policies')->first();
                // $policies = $policies[0];
                $policies->content = Parsedown::instance()->text(Storage::disk('general_upload')->get($policies->content));
                return view('policies')->with('policy', $policies)->with('windowsRDP', $windowsRDP)
                    ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)->with('counts', $planCount)
                    ->with('configuration', $configuration)
                    ->with('rdplocation', $rdplocation)
                    ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)->with('description', $description)
                    ->with('author', $author)->with('title', $title);
            case "terms":
                $policies = DB::table('policies')->where('type', 'terms_of_services')->first();
                // $policies = $policies[0];
                $policies->content = Parsedown::instance()->text(Storage::disk('general_upload')->get($policies->content));
                return view('policies')->with('policy', $policies)->with('windowsRDP', $windowsRDP)
                    ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)->with('counts', $planCount)
                    ->with('rdplocation', $rdplocation)
                    ->with('configuration', $configuration)
                    ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
                    ->with('description', $description)
                    ->with('author', $author)->with('title', $title);
            case "refund":
                $policies = DB::table('policies')->where('type', 'refund_policies')->first();
                // $policies = $policies[0];
                $policies->content = Parsedown::instance()->text(Storage::disk('general_upload')->get($policies->content));
                return view('policies')->with('policy', $policies)->with('windowsRDP', $windowsRDP)
                    ->with('cloudVPS', $cloudVPS)->with('faqs', $faqs)->with('counts', $planCount)
                    ->with('rdplocation', $rdplocation)
                    ->with('testimonials', $testimonials)->with('dedicatedServer', $dedicatedServer)
                    ->with('description', $description)
                    ->with('configuration', $configuration)
                    ->with('author', $author)->with('title', $title);
            default:
                return redirect("/");
        }
    }

    public function Error404()
    {
        $windowsRDP = DB::table('windows_rdps')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $cloudVPS =  DB::table('v_p_s')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $rdplocation =  DB::table('r_d_p_by_locations')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $configuration = Configuration::find(1);
        $dedicatedServer =  DB::table('dedicateds')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->get();
        $offers = DB::table('offers')->where('is_published', 1)
            ->orderBy('created_at', 'desc')->limit(3)->get();
        $planCount = [
            "wrdp" => DB::table('r_d_p_plans')->get()->count(),
            "clvps" => DB::table('v_p_s_plans')->get()->count(),
            "dedicated" => DB::table('dedicated_plans')->get()->count(),
            "rdplocation" => DB::table('r_d_p_by_location_plans')->get()->count()
        ];
        $faqs = DB::table('f_a_q_s')->limit(4)->get();
        $testimonials = DB::table('testimonials')->limit(4)->get();
        $rdpPlan = DB::table('r_d_p_plans')->where('is_published', 1)
            ->orderBy('priority', 'desc')->limit(3)->get();
        $dedicatedPlans = DB::table('dedicated_plans')->where('is_published', 1)
            ->orderBy('priority', 'desc')->limit(3)->get();
        $cloudPlan = DB::table('v_p_s_plans')->where('is_published', 1)
            ->orderBy('priority', 'desc')->limit(3)->get();
        $rdpLocationPlan = DB::table('r_d_p_by_location_plans')->where('is_published', 1)
            ->orderBy('priority', 'desc')->limit(3)->get();
        $description = "Sorry page was not found";
        $author = "DigiRDP admin";
        $title = "404 Page Not Found";


        $features_card = DB::table('features_card')->get();

        return view('custom_errors.404')->with('windowsRDP', $windowsRDP)
            ->with('cloudVPS', $cloudVPS)
            ->with('rdplocation', $rdplocation)
            ->with('rdpLocationPlan', $rdpLocationPlan)
            ->with('offers', $offers)
            ->with('dedicatedServer', $dedicatedServer)
            ->with('rdpPlans', $rdpPlan)
            ->with('dedicatedPlans', $dedicatedPlans)
            ->with('cloudPlan', $cloudPlan)
            ->with('faqs', $faqs)
            ->with('counts', $planCount)
            ->with('configuration', $configuration)
            ->with('testimonials', $testimonials)->with('description', $description)
            ->with('author', $author)->with('title', $title)
            ->with('features_card', $features_card);
    }
    /**
    Code By Aditya Rathore
    */
    public function cachedQuerySetProducts($name,$table){
        $data = cache()->remember($name, now()->addHours(24), function () use ($table) {
            return DB::table($table)->where('is_published', 1)->orderBy('created_at', 'desc')->get();
        });
        return $data;
    }
    public function cachedQuerySetPlans($name,$table,$limit = 3){
        $data = cache()->remember($name, now()->addHours(24), function () use ($table, $limit) {
            return DB::table($table)->where('is_published', 1)->orderBy('priority', 'desc')->limit($limit)->get();
        });
        return $data;
    }
    public function dbCount($table)
    {
        $data = DB::table($table)->count();
        return $data;
    }
    public function planCount(){
        return [
            "wrdp" => $this->dbCount('r_d_p_plans'),
            "clvps" => $this->dbCount('v_p_s_plans'),
            "dedicated" => $this->dbCount('dedicated_plans'),
            "rdplocation" => $this->dbCount('r_d_p_by_location_plans')
        ];
    }
    public function DBconfiguration(){
        $data = cache()->remember('configuration', now()->addHours(24), function () {
            return Configuration::find(1);
        });
        return $data;
    }
    public function DBfaq($limit = 4){
        $data = cache()->remember('faqs', now()->addHours(24), function () use ($limit) {
            return DB::table('f_a_q_s')->limit($limit)->get();
        });
        return $data;
    }
    public function DBoffers($limit = 3){
       $data = cache()->remember('offers', now()->addHours(24), function () use ($limit){
            return DB::table('offers')->where('is_published', 1)->orderBy('created_at', 'desc')->limit($limit)->get();
        });
        return $data;
    }
    public function DBtestimonials($limit = 4){
        $data = cache()->remember('testimonials', now()->addHours(24), function () use ($limit){
            return DB::table('testimonials')->limit($limit)->get();
        });
        return $data;
    }
    public function DBfeaturesCard(){
        $data = cache()->remember('features_card', now()->addHours(24), function () {
            return DB::table('features_card')->get();
        });
        return $data;
    }

    public function DBsliders(){
        $data = cache()->remember('sliders', now()->addHours(24), function () {
            return DB::table('sliders')->get();
        });
        return $data;
    }

    public function DBblog(){
        $data = cache()->remember('posts', now()->addHours(24), function () {
            return DB::table('posts')->join('users','posts.post_by','=','users.id')
            ->select('posts.*', 'users')
            ->get();
        });
        // dd($data);
        return $data;
    }
}
