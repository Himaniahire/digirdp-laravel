<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Session, Validator, File, Auth;

class TestimonialsController extends Controller
{
    private $uploadPath     = "uploads/testimonials";
    private $modelname      = "App\Models\Testimonials";
    private $localname      = "testimonials";
    private $tablename      = "testimonials";
    private $imageinputname = array('img_url');

    private $route = array('create' => 'testimonials.create',
        'edit' => 'testimonials.edit',
        'index' => 'testimonials.index',
        'show' => 'testimonials.show',
        'store' => 'testimonials.store',
        'update' => 'testimonials.update',
        'destroy' => 'testimonials.destroy',
    );
    private $view = array('create' => 'admin.testimonials.create',
        'edit' => 'admin.testimonials.edit',
        'index' => 'admin.testimonials.index',
        'show' => 'admin.testimonials.show');

    private $indexvariables = array(
        'title' => 'ALL Testimonials',
        'newitem' => 'NEW Testimonials',
        'url' => 'testimonials'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW TESTIMONIALS',
        'newitem' => 'NEW TESTIMONIAL',
    );

    private $showvariables = array(
        'title' => 'TESTIMONIALS DETAILS',
        'seeall' => 'SEE ALL TESTIMONIALSS',
    );

    private $saveSuccess    = 'The testimonial was successfully saved.';
    private $deletionSuccess = 'testimonial Deleted Successfully';
    private $updationSuccess = 'testimonial updated Successfully';
    private $singlepostvar  = "testimonial";
    private $multipostvar   = "testimonials";
    private $indexpagination = 10;

    private $validation_rules = array(
        'name' => 'required',
        'img_url' => 'required',
        'testimonials'=> 'required',
    );

    private $update_validation_rules = array(
        'name' => 'required',
        'img_url' => 'required',
        'testimonials'=> 'required',
    );

    private $formfields = array(

        'name' => array('name'  =>  'name',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'testimonial Name',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Name',
                'required' => ''
            )
        ),


        'testimonials' => array('name'  =>  'testimonials',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'testimonial Content',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'textarea',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'testimonials',
                'placeholder' => 'Enter Testimonials Here',
                'required' => 'required',
                'rows' => 5
            )
        ),

        'img_url'=> array('name'  =>  'img_url',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-6',
            'label' => 'Upload Photo',
            'field_icon' => 'fa fa-file',
            'type'  =>  'file',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'img_url',
                'placeholder' => 'Enter cat image here'
            )
        ),

    );

    private $indexfields = array(
        'id' => array('label' => '#'),
        'name'  => array('label' => 'Name' ),
        'testimonials'  => array('label' => 'Testimonials' ),
        'image'  => array('label' => 'Image' ),
        'created_at'=> array('label' => 'Created At'),
        'updated_at'=> array('label' => 'Updated At'),
    );




    private $showfields = array(
        'id' => array('label' => '#'),
        'name'  => array('label' => 'Name' ),
        'testimonials'  => array('label' => 'Testimonials' ),
        'image'  => array('label' => 'Image' ),
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
        $posts = $this->modelname::orderBy('id', 'desc')->paginate($this->indexpagination);
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
        $fields = $this->formfields;

        return view($this->view['create'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with('createvar', $this->createvariables);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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
                        File::delete($post->imginpname);
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
}
