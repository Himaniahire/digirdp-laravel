<?php

namespace App\Http\Controllers;

use App\Models\RDPByLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\RDPByLocationPlan;
use Session, Validator, File, Auth;

class RDPByLocationPlanController extends Controller
{
    private $uploadPath     = "uploads/rdplocationplan";
    private $modelname      = "App\Models\RDPByLocationPlan";
    private $localname      = "rdplocationplan";
    private $tablename      = "rdplocationplan";
    private $imageinputname = array('image');
    private $publishfield   = "is_published";

    private $route = array('create' => 'rdplocationplan.create',
        'edit' => 'rdplocationplan.edit',
        'index' => 'rdplocationplan.index',
        'show' => 'rdplocationplan.show',
        'store' => 'rdplocationplan.store',
        'update' => 'rdplocationplan.update',
        'destroy' => 'rdplocationplan.destroy',
        'publish' => 'rdplocationplan.publish',
        'unpublish' => 'rdplocationplan.unpublish',
        'duplicate' => 'rdplocationplan.duplicate'
    );
    private $view = array('create' => 'rdplocationplan.create',
        'edit' => 'rdplocationplan.edit',
        'index' => 'rdplocationplan.index',
        'show' => 'rdplocationplan.show');

    private $indexvariables = array(
        'title' => 'ALL RDP By Location Plan',
        'newitem' => 'NEW RDP By Location Plan',
        'url' => 'rdplocationplan',
        'urltomain' => 'rdplocationplan/'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW RDP By Location Plan',
        'newitem' => 'NEW RDP By Location Plan',
    );

    private $showvariables = array(
        'title' => 'RDP By Location Plan DETAILS',
        'seeall' => 'SEE ALL RDP By Location Plan',
    );

    private $saveSuccess    = 'The RDP By Location Plan was successfully saved.';
    private $deletionSuccess = 'RDP By Location Plan Deleted Successfully';
    private $updationSuccess = 'RDP By Location Plan updated Successfully';
    private $publishSuccess = 'RDP By Location Plan published Successfully';
    private $unpublishSuccess = 'RDP By Location Plan unpublished Successfully';
    private $singlepostvar  = "rdplocationplan";
    private $multipostvar   = "rdplocationplan";
    private $indexpagination = 10;

    private $validation_rules = array(
        'name' => 'required',
        'rdp_id'    => 'required',
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
        'rdp_id'    => 'required',
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
                'placeholder' => 'Enter RDP By Location PLAN Number of users',
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
                'placeholder' => 'Enter RDP By Location Plan Name here',
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
                'placeholder' => 'Enter RDP By Location Plan Price Here',
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
                'placeholder' => 'Enter RDP By Location Plan name here',
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
                'placeholder' => 'Enter RDP By Location Plan CPU here',
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
            'label' => 'RDP By Location Plan URL',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter RDP By Location Plan URL here',
                'required' => ''
            )
        ),
        'plan_stock' => array('name'  =>  'plan_stock',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'RDP By Location Plan STOCK',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter RDP By Location Plan STOCK here',
                'required' => ''
            )
        ),
        'rdp_id'=> array('name'  =>  'rdp_id',
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
                'placeholder' => 'Enter RDP By Location Plan Description here',
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
                'placeholder' => 'Enter RDP By Location Plan Traffic here',
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
                'placeholder' => 'Enter RDP By Location Plan Drives here',
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
                'placeholder' => 'Enter RDP By Location Plan RAM here',
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
                'placeholder' => 'Enter RDP By Location Plan Free here',
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
                'placeholder' => 'Enter RDP By Location Plan Location here',
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
//        'RDPByLocation_name'  => array('label' => 'Belongs to Server'),
        'name'  => array('label' => 'Name' ),
        // 'updated_at'=> array('label' => 'Updated At'),
    );




    private $showfields = array(
        'id' => array('label' => '#'),
        'rdp_id'  => array('label' => 'Belongs to Server'),
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


    public function index()
    {
        $posts = $this->modelname::orderBy('id', 'desc')->get();
        $fields = $this->indexfields;
        return view($this->view['index'])->with($this->multipostvar, $posts)
            ->with('fields', $fields)
            ->with('multipostvar', $this->multipostvar)
            ->with('route', $this->route)
            ->with('indexvar', $this->indexvariables)
            ->with('uploadPath',url($this->uploadPath));
    }



    public function create()
    {
        // $timenow = time();
        $fields = $this->formfields;
        $dedicated = RDPByLocation::all();
        $fields['rdp_id']['choices'] = array();
        foreach($dedicated as $d)
        {
            $fields['rdp_id']['choices'][$d->id] = $d->name;
        }
        return view($this->view['create'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with('createvar', $this->createvariables);
    }


    public function createByDedicated($rdp_id)
    {
        // $timenow = time();
        $fields = $this->formfields;
        $branchs = RDPByLocation::all();
        $fields['rdp_id']['choices'] = array();
        foreach($branchs as $branch)
        {
            $fields['rdp_id']['choices'][$branch->id] = $branch->name;
        }
        $fields['rdp_id']['default'] = $rdp_id;
        return view($this->view['create'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with('createvar', $this->createvariables);
    }

    public function store(Request $request)
    {
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

    public function show($id)
    {
        $fields = $this->showfields;
        $post = $this->modelname::find($id);
        if($post)
        {
            $branch = RDPByLocation::find($post->rdp_id);
            $post->rdp_id = $branch->name;
            $post->RDPByLocation_aid = $branch->id;
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

    public function edit($id)
    {
        $fields = $this->formfields;
        $post = $this->modelname::find($id);

        $branchs = RDPByLocation::all();
        $fields['rdp_id']['choices'] = array();
        foreach($branchs as $branch)
        {
            $fields['rdp_id']['choices'][$branch->id] = $branch->name;
        }

        return view($this->view['edit'])->with($this->singlepostvar ,$post)
            ->with('route', $this->route)
            ->with('fields', $fields)
            ->with('singlepostvar', $this->singlepostvar)
            ->with('uploadPath',url($this->uploadPath));
    }

    public function update(Request $request, $id)
    {
        $imageName = null;
        $post = $this->modelname::find($id);

        $updaterules = $this->update_validation_rules;
        $updaterules['slug'] = array('alpha_dash', Rule::unique('rdplocationplan')->ignore($id));


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
        Session::flash('success', $this->unpublishSuccess);
        return redirect()->back();
    }


    public function unpublish($id)
    {
        $publishfield = $this->publishfield;
        $post = $this->modelname::find($id);
        $post->$publishfield = 0;
        $post->save();
        Session::flash('success', $this->publishSuccess);
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
