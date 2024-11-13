<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session, Validator, File, Auth;
use Storage;

class SliderController extends Controller
{
    private $uploadPath     = "uploads/sliders";
    private $modelname      = "App\Models\Slider";
    private $localname      = "sliders";
    private $tablename      = "sliders";
    private $imageinputname = "slider_image";
    private $publishfield   = "is_published";

    private $route = array('create' => 'sliders.create',
        'edit' => 'sliders.edit',
        'index' => 'sliders.index',
        'show' => 'sliders.show',
        'store' => 'sliders.store',
        'update' => 'sliders.update',
        'destroy' => 'sliders.destroy',
        'publish' => 'sliders.publish',
        'unpublish' => 'sliders.unpublish'
    );
    private $view = array('create' => 'admin.sliders.create',
        'edit' => 'admin.sliders.edit',
        'index' => 'admin.sliders.index',
        'show' => 'admin.sliders.show');

    private $indexvariables = array(
        'title' => 'ALL SLIDERS',
        'newitem' => 'NEW SLIDER',
        'url' => 'sliders'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW SLIDER',
        'newitem' => 'NEW SLIDER',
    );

    private $showvariables = array(
        'title' => 'SLIDER DETAILS',
        'seeall' => 'SEE ALL SLIDERS',
    );

    private $saveSuccess    = 'The slider was successfully saved.';
    private $deletionSuccess = 'Slider Deleted Successfully';
    private $updationSuccess = 'Slider Updated Successfully';
    private $singlepostvar  = "slider";
    private $multipostvar   = "sliders";
    private $indexpagination = 10;

    private $validation_rules = array(
        'slider_heading' => 'required',
        'slider_image'=> 'required|max:2048',
        'slider_details' => 'required',
        'is_published'=> 'required',
    );

    private $update_validation_rules = array(
        'slider_heading' => 'required',
        'slider_image'=> 'required|max:2048',
        'slider_details' => 'required',
        'is_published'=> 'required',
    );

    private $formfields = array(

        'slider_image'=> array('name'  =>  'slider_image',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-6',
            'label' => 'Slider Image',
            'field_icon' => 'glyphicon glyphicon-file',
            'type'  =>  'file',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'slider_image',
                'placeholder' => 'Enter Slider image here'
            )
        ),

        'slider_heading' => array('name'  =>  'slider_heading',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Slider Heading',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'slider_heading',
                'placeholder' => 'Enter Slider name here',
                'required' => ''
            )
        ),

        'slider_details' => array('name'  =>  'slider_details',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Slider Details',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'slider_details',
                'placeholder' => 'Enter Slider name here',
                'required' => ''
            )
        ),


        'is_published'=> array('name'  =>  'is_published',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => ' Is Published ?',
            'field_icon' => 'glyphicon glyphicon-saved',
            'type'  =>  'select',
            'default' => null,
            'choices' => array('0' => 'Save As Draft',
                '1' => 'Publish Now'),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'is_published',
                'placeholder' => 'Enter news message here',
                'required' => ''
            )
        )

    );

    private $indexfields = array(
        'id' => array('label' => '#'),
        'slider_heading'  => array('label' => 'Slider Name' ),
        'slider_image' => array('label' => 'Slider Image' ),
        'created_at'=> array('label' => 'Created At'),
        'updated_at'=> array('label' => 'Updated At'),
    );




    private $showfields = array(
        'id' => array('label' => 'Sliders ID'),
        'slider_heading'  => array('label' => 'Slider Name' ),
        'slider_image' => array('label' => 'Slider Image' ),
        'slider_details' => array('label' => 'Slider Details' ),
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
        // $timenow = time();
        $fields = $this->formfields;

        return view($this->view['create'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with('createvar', $this->createvariables);
    }




    public function processFile($post, Request $request, $update = 0)
    {
        if(!empty($this->imageinputname) && $request->hasFile($this->imageinputname)){
            if ($request->file($this->imageinputname)->isValid())
            {
                $imginpname = $this->imageinputname;

                if($update)
                {
                    File::delete($post->imginpname);
                }
                $imageName = time().'.'.$request->$imginpname->getClientOriginalExtension();


                $request->$imginpname->move($this->uploadPath, $imageName);

                $pathToImage = $post->$imginpname = $this->uploadPath.'/'.$imageName;
            }
            else
            {
                Session::flash('warning', 'Uploaded file is not valid');
                return redirect()->route($this->route['create'])->withErrors($validator)->withInput();
            }
        }
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

        $this->processFile($post, $request);

        foreach ($this->formfields as $fieldname => $fieldvalue) {
            if(strcmp($fieldname, $this->imageinputname))
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

        $this->processFile($post, $request, 1);

        foreach ($this->formfields as $fieldname => $fieldvalue) {
            if(strcmp($fieldname, $this->imageinputname))
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
            File::delete($post->$inpname);
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
        return redirect()->route($this->route['index']);
    }


    public function unpublish($id)
    {
        $publishfield = $this->publishfield;
        $post = $this->modelname::find($id);
        $post->$publishfield = 0;
        $post->save();
        return redirect()->route($this->route['index']);
    }
}
