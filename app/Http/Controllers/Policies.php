<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session, Validator, File, Auth;
use Storage;

class Policies extends Controller
{
    private $uploadPath     = "uploads/updates";
    private $modelname      = "App\Models\Policies";
    private $localname      = "policies";
    private $tablename      = "policies";
    private $imageinputname = array('content');
    private $publishfield   = "is_published";

    private $route = array('create' => 'policies.create',
        'edit' => 'policies.edit',
        'index' => 'policies.index',
        'show' => 'policies.show',
        'store' => 'policies.store',
        'update' => 'policies.update',
        'destroy' => 'policies.destroy',
    );
    private $view = array('create' => 'policies.create',
        'edit' => 'policies.edit',
        'index' => 'policies.index',
        'show' => 'policies.show');

    private $indexvariables = array(
        'title' => 'ALL POLICIES',
        'newitem' => 'NEW POLICIES',
        'url' => 'policies',
        'urltomain' => 'policies/'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW POLICIES',
        'newitem' => 'NEW POLICIES',
    );

    private $showvariables = array(
        'title' => 'POLICIES DETAILS',
        'seeall' => 'SEE ALL POLICIES',
    );

    private $saveSuccess    = 'The POLICIES was successfully saved.';
    private $deletionSuccess = 'POLICIES Deleted Successfully';
    private $updationSuccess = 'POLICIES POLICIESd Successfully';
    private $singlepostvar  = "POLICIES";
    private $multipostvar   = "POLICIES";
    private $indexpagination = 10;

    private $validation_rules = array(
        'name'      => 'required',
        'type' => 'required',
        'content' => 'required',
    );

    private $update_validation_rules = array(
        'name'      => 'required',
        'type' => 'required',
        'content' => 'required',
    );

    private $formfields = array(
        'name' => array('name'  =>  'name',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-8',
            'label' => 'name',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'header',
                'placeholder' => 'Enter Name',
                'required' => ''
            )
        ),
        'type' => array('name'  =>  'type',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-8',
            'label' => 'Description',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'select',
            'default' => null,
            'choices' => array('refund_policies' => 'Refund Policies',
                'privacy_policies' => 'Privacy Policies',
                'reseller_policy' => 'Reseller Policies',
                'terms_of_services' => 'Terms Of Services'),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'description',
                'placeholder' => 'Enter Policy Type Here',
                'required' => '',
                'rows' => 5
            )
        ),
        'content' => array('name'  =>  'content',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-8',
            'label' => 'Content',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'textarea',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'header',
                'placeholder' => 'Enter Eligibility Here',
                'required' => '',
                'rows' => 20,
                'cols' => 80
            )
        ),
        'start_date' => array('name'  =>  'start_date',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-8',
            'label' => 'Policy Start Date',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'header',
                'placeholder' => 'Enter Policy Start Date Here',
                'required' => '',
            )
        ),
    );

    private $indexfields = array(
        'id' => array('label' => '#'),
        'name' => array('label' => 'Name'),
        'type' => array('label' => 'Type'),
        'start_date'=> array('label' => 'Start Date'),
    );

    private $showfields = array(
        'id' => array('label' => '#'),
        'name' => array('label' => 'Name'),
        'type' => array('label' => 'Type'),
        'start_date'=> array('label' => 'Start Date'),
        'content' => array('label' => 'Content'),
        // 'updated_at'=> array('label' => 'Updated At'),
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
                        if($imginpname == 'image')
                        {
                            $imageName = time().rand(5000,10000).'.'.$request->$imginpname->getClientOriginalExtension();
                            $request->$imginpname->move($this->uploadPath, $imageName);
                            $post->$imginpname = $this->uploadPath.'/'.$imageName;
                        }

                    }
                    else
                    {
                        Session::flash('warning', 'Uploaded file is not valid');
                        return redirect()->route($this->route['create'])
                            ->withErrors($validator)
                            ->withInput();
                    }
                }
                else
                {
                    $name = time().rand(5000,10000).'.md';
                    Storage::disk('general_upload')->put($name,$request->$imginpname);
                    $post->$imginpname = $name;
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
        $post->content = Storage::disk('general_upload')->get($post->content);

        return view($this->view['show'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with($this->singlepostvar, $post)
            ->with('singlepostvar', $this->singlepostvar)
            ->with('showvar', $this->showvariables)
            ->with('uploadPath',url($this->uploadPath));
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
        $post->content = Storage::disk('general_upload')->get($post->content);

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
                        Storage::disk('public_uploads')->delete($post->imginpname);
                        $imageName = time().rand(5000,10000).'.'.$request->$imginpname->getClientOriginalExtension();
                        $request->$imginpname->move($this->uploadPath, $imageName);
                        $post->$imginpname = $this->uploadPath.'/'.$imageName;
                    }
                    else
                    {
                        Session::flash('warning', 'Uploaded file is not valid');
                        return back()->withErrors($validator)->withInput();
                    }
                }
                else
                {
                    Storage::disk('general_upload')->delete($post->imginpname);
                    $name = time().rand(5000,10000).'.md';
                    Storage::disk('general_upload')->put($name,$request->$imginpname);
                    $post->$imginpname = $name;
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
                Storage::disk('general_upload')->delete($post->$img);
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
}
