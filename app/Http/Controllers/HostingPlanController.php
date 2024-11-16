<?php

namespace App\Http\Controllers;

use App\Models\Hosting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session, Validator, File, Auth;

class HostingPlanController extends Controller
{
    private $uploadPath     = "uploads/hostingplans";
    private $modelname      = "App\Models\HostingPlans";
    private $localname      = "HostingPlan";
    private $tablename      = "HostingPlan";
    private $imageinputname = array('image');
    private $publishfield   = "is_published";

    private $route = array('create' => 'hostingplan.create',
        'edit' => 'hostingplan.edit',
        'index' => 'hostingplan.index',
        'show' => 'hostingplan.show',
        'store' => 'hostingplan.store',
        'update' => 'hostingplan.update',
        'destroy' => 'hostingplan.destroy',
        'publish' => 'hostingplan.publish',
        'unpublish' => 'hostingplan.unpublish',
        'duplicate' => 'hostingplan.duplicate'
    );
    private $view = array('create' => 'hostingplan.create',
        'edit' => 'hostingplan.edit',
        'index' => 'hostingplan.index',
        'show' => 'hostingplan.show');

    private $indexvariables = array(
        'title' => 'ALL Hosting PLAN',
        'newitem' => 'NEW Hosting PLAN',
        'url' => 'hostingplan',
        'urltomain' => 'hostingplan/'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW Hosting PLAN',
        'newitem' => 'NEW Hosting PLAN',
    );

    private $showvariables = array(
        'title' => 'Hosting PLAN DETAILS',
        'seeall' => 'SEE ALL Hosting PLAN',
    );

    private $saveSuccess    = 'The Hosting PLAN was successfully saved.';
    private $deletionSuccess = 'Hosting PLAN Deleted Successfully';
    private $updationSuccess = 'Hosting PLAN updated Successfully';
    private $singlepostvar  = "hostingplan";
    private $multipostvar   = "hostingplan";
    private $indexpagination = 10;

    private $validation_rules = array(
        'name' => 'required',
        'hosting_id'    => 'required',
        'price' => 'required',
        'plan_stock' => 'required',
        'tag' => 'required',
        'processor' => 'required',
        'cpu' => 'required',
        'location' => 'required',
        'priority' => 'required',
        'users' => 'required',
        'is_published'=> 'required',
    );

    private $update_validation_rules = array(
        'name' => 'required',
        'hosting_id'    => 'required',
        'price' => 'required',
        'plan_stock' => 'required',
        'tag' => 'required',
        'processor' => 'required',
        'cpu' => 'required',
        'location' => 'required',
        'priority' => 'required',
        'users' => 'required',
        'is_published'=> 'required',
    );

    private $formfields = array(
        'users' => array('name'  =>  'users',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'No of Users',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter DEDICATED PLAN Number of users',
                'required' => ''
            )
        ),
        'name' => array('name'  =>  'name',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Name',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN Name here',
                'required' => ''
            )
        ),
        'price' => array('name'  =>  'price',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Price',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN Price Here',
                'required' => ''
            )
        ),
        'offer_price' => array('name'  =>  'offer_price',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Offer Price',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Offer Price Here',
                'required' => ''
            )
        ),
        'processor' => array('name'  =>  'processor',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Processor',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN name here',
                'required' => ''

            )
        ),
        'cpu' => array('name'  =>  'cpu',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'CPU',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN CPU here',
                'required' => ''
            )
        ),
        'a' => array('name'  =>  'a',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Field One',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Extra Field Here',
            )
        ),
        'b' => array('name'  =>  'b',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Field Two',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Extra Field Here',
            )
        ),
        'c' => array('name'  =>  'c',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Field Three',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Extra Field Here',
            )
        ),
        'd' => array('name'  =>  'd',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Field Four',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Extra Field Here',
            )
        ),
        'e' => array('name'  =>  'e',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Field Five',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Extra Field Here',
            )
        ),
        'tag' => array('name'  =>  'tag',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Dedicated PLAN Tag',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'select',
            'default' => null,
            'choices' => array(
                'new' => 'new',
                'popular' => 'popular',
                'limitedEdition' => 'LIMITED EDITION',
                'hot' => 'Hot',
                'featured' => 'Featured',
                'none' => 'None'
            ),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Dedicated PLAN Tag here',
                'required' => ''
            )
        ),
        'plan_url' => array('name'  =>  'plan_url',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Hosting PLAN URL',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN URL here',
                'required' => ''
            )
        ),
        'plan_stock' => array('name'  =>  'plan_stock',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Hosting PLAN STOCK',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN STOCK here',
                'required' => ''
            )
        ),
        'hosting_id'=> array('name'  =>  'hosting_id',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Choose Branch',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'select',
            'default' => null,
            'choices' => array(),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'branch_id',
                'placeholder' => 'Choose Dedicated Server here.',
                'required' => ''
            )
        ),

        'priority'=> array('name'  =>  'priority',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Priority',
            'field_icon' => 'fa fa-download',
            'type'  =>  'select',
            'default' => null,
            'choices' => array(0 => 0,
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'priority',
                'placeholder' => 'Please select the priority to the paln',
                'required' => ''
            )
        ),
        'description' => array('name'  =>  'description',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Description',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN Description here',
            )
        ),
        'traffic' => array('name'  =>  'traffic',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Traffic',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN Traffic here',
            )
        ),
        'drives' => array('name'  =>  'drives',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Drives',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN Drives here',
            )
        ),
        'ram' => array('name'  =>  'ram',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Ram',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN RAM here',
            )
        ),
        'free' => array('name'  =>  'free',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Free',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN Free here',
            )
        ),
        'location' => array('name'  =>  'location',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Location',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Hosting PLAN Location here',
            )
        ),
        'os' => array('name'  =>  'os',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Operating System',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Operating System here',
            )
        ),
        'bandwidth' => array('name'  =>  'bandwidth',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Bandwidth',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Bandwidth here',
            )
        ),
        'ip' => array('name'  =>  'ip',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'IP Address',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter IP Address here',
            )
        ),
        'uptime' => array('name'  =>  'uptime',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Uptime',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Uptime here',
            )
        ),
        'is_published'=> array('name'  =>  'is_published',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => ' Is Published ?',
            'field_icon' => 'fa fa-download',
            'type'  =>  'select',
            'default' => null,
            'choices' => array('0' => 'Save As Draft',
                '1' => 'Publish Now'),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'is_published',
                'placeholder' => 'Do you want to publish it now?',
                'required' => ''
            )
        )
    );

    private $indexfields = array(
        'id' => array('label' => '#'),
//        'Hosting_name'  => array('label' => 'Belongs to Server'),
        'name'  => array('label' => 'Name' ),
        // 'updated_at'=> array('label' => 'Updated At'),
    );




    private $showfields = array(
        'id' => array('label' => '#'),
        'hosting_id'  => array('label' => 'Belongs to Server'),
        'name'  => array('label' => 'Name'),
        'price' => array('label' => 'price'),
        'offer_price' => array('label' => 'Offer Price'),
        'description' => array('label' => 'description'),
        'tag' => array('label' => 'tag'),
        'processor' => array('label' => 'processor'),
        'cpu' => array('label' => 'cpu'),
        'traffic' => array('label' => 'traffic'),
        'drives' => array('label' => 'drives'),
        'ram' => array('label' => 'ram'),
        'plan_url' => ['label' => 'Plan URL'],
        'plan_stock' => ['label' => 'Plan STOCK'],
        'free' => array('label' => 'free'),
        'location' => array('label' => 'location'),
        'priority' => array('label' => 'priority'),
    );


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->modelname::orderBy('id', 'desc')->get();

//        foreach($posts as $post)
//        {
//            $branch = WindowsHosting::find($post->hosting_id);
////            dd($branch->name, $post->hosting_id);
//            $post->Hosting_name = $branch->name;
//        }

        $fields = $this->indexfields;

        return view($this->view['index'])->with($this->multipostvar, $posts)
            ->with('fields', $fields)
            ->with('multipostvar', $this->multipostvar)
            ->with('route', $this->route)
            ->with('indexvar', $this->indexvariables)
            ->with('uploadPath',url($this->uploadPath));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $timenow = time();
        $fields = $this->formfields;
        $dedicated = Hosting::all();
        $fields['hosting_id']['choices'] = array();
        foreach($dedicated as $d)
        {
            $fields['hosting_id']['choices'][$d->id] = $d->name;
        }
        return view($this->view['create'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with('createvar', $this->createvariables);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createByDedicated($hosting_id)
    {
        // $timenow = time();
        $fields = $this->formfields;
        $branchs = Hosting::all();
        $fields['hosting_id']['choices'] = array();
        foreach($branchs as $branch)
        {
            $fields['hosting_id']['choices'][$branch->id] = $branch->name;
        }
        $fields['hosting_id']['default'] = $hosting_id;
        return view($this->view['create'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with('createvar', $this->createvariables);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = null;
        $this->validate($request, $this->validation_rules);

        $post = new $this->modelname;

        if(!empty($this->imageinputname))
        {

            $imginpnames = $this->imageinputname;

            foreach ($imginpnames as $imginpname)
            {

                if($request->hasFile($imginpname))
                {
                    if ($request->file($imginpname)->isValid())
                    {

                        $imageName = time().rand(5000,10000).'.'.$request->$imginpname->getClientOriginalExtension();

                        $request->$imginpname->move($this->uploadPath, $imageName);
                        $pathToImage = $this->uploadPath.'/'.$imageName;

                        $post->$imginpname = $this->uploadPath.'/'.$imageName;
                    }
                    else
                    {
                        Session::flash('warning', 'Uploaded file is not valid');
                        return redirect()->route($this->route['create'])
                            ->withErrors($validator)
                            ->withInput();
                    }
                }

            }

        }


        foreach ($this->formfields as $fieldname => $fieldvalue) {
            if(!in_array($fieldname, $this->imageinputname))
                $post->$fieldname = $request->$fieldname;
        }

        $post->save();

        Session::flash('success', $this->saveSuccess);

        return redirect()->route($this->route['show'], $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fields = $this->showfields;
        $post = $this->modelname::find($id);
        if($post)
        {
            $branch = Hosting::find($post->hosting_id);
            $post->hosting_id = $branch->name;
            $post->Hosting_aid = $branch->id;
            return view($this->view['show'])->with('fields', $fields)
                ->with('route', $this->route)
                ->with($this->singlepostvar, $post)
                ->with('singlepostvar', $this->singlepostvar)
                ->with('showvar', $this->showvariables)
                ->with('uploadPath',url($this->uploadPath));
        }else{
            abort(404, 'Page not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = $this->formfields;
        $post = $this->modelname::find($id);

        $branchs = Hosting::all();
        $fields['hosting_id']['choices'] = array();
        foreach($branchs as $branch)
        {
            $fields['hosting_id']['choices'][$branch->id] = $branch->name;
        }

        return view($this->view['edit'])->with($this->singlepostvar ,$post)
            ->with('route', $this->route)
            ->with('fields', $fields)
            ->with('singlepostvar', $this->singlepostvar)
            ->with('uploadPath',url($this->uploadPath));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imageName = null;
        $post = $this->modelname::find($id);

        $updaterules = $this->update_validation_rules;
        $updaterules['slug'] = array('alpha_dash', Rule::unique('hostingplan')->ignore($id));


        $this->validate($request, $updaterules);

        if(!empty($this->imageinputname))
        {

            $imginpnames = $this->imageinputname;

            foreach ($imginpnames as $imginpname)
            {

                if($request->hasFile($imginpname))
                {
                    if ($request->file($imginpname)->isValid())
                    {
                        File::delete($post->imginpname);
                        $imageName = time().rand(5000,10000).'.'.$request->$imginpname->getClientOriginalExtension();
                        $request->$imginpname->move($this->uploadPath, $imageName);
                        $pathToImage = $this->uploadPath.'/'.$imageName;

                        GlideImage::create($pathToImage)
                            ->modify(['w'=> 500, 'h' => 350])
                            ->save($pathToImage);

                        $post->$imginpname = $this->uploadPath.'/'.$imageName;
                    }
                    else
                    {
                        Session::flash('warning', 'Uploaded file is not valid');
                        return back()->withErrors($validator)->withInput();
                    }
                }

            }

        }

        foreach ($this->formfields as $fieldname => $fieldvalue) {
            if(!in_array($fieldname, $this->imageinputname))
                $post->$fieldname = $request->$fieldname;
        }
        $post->save();

        Session::flash('success', $this->updationSuccess);

        return redirect()->route($this->route['show'], $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->modelname::find($id);
        if(!empty($this->imageinputname))
        {
            $inpname = $this->imageinputname;
            foreach ($inpname as $img) {
                File::delete($post->$img);
            }

        }
        $post->delete();
        Session::flash('success', $this->deletionSuccess);
        return redirect()->route($this->route['index']);
    }


    public function publish($id)
    {
        $publishfield = $this->publishfield;
        $post = $this->modelname::find($id);
        $post->$publishfield = 1;
        $post->save();
        return redirect()->back();
    }


    public function unpublish($id)
    {
        $publishfield = $this->publishfield;
        $post = $this->modelname::find($id);
        $post->$publishfield = 0;
        $post->save();
        return redirect()->back();
    }

    /**
     * Duplicate the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $post = $this->modelname::find($id);
        $newpost = $post->replicate();
        $newpost->name = $newpost->name.' Copy';
        $newpost->is_published = 0;
        $newpost->push();
        return redirect()->route($this->route['index']);
    }
}
