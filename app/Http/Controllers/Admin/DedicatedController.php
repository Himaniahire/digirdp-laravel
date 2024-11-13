<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DedicatedPlan;
use Illuminate\Http\Request;
use Session, Validator, File, Auth;

class DedicatedController extends Controller
{
    private $uploadPath     = "uploads/dedicated";
    private $modelname      = "App\Models\Dedicated";
    private $localname      = "dedicated";
    private $tablename      = "dedicated";
    private $imageinputname = "logo";
    private $publishfield   = "is_published";

    private $route = array('create' => 'dedicated.create',
        'edit' => 'dedicated.edit',
        'index' => 'dedicated.index',
        'show' => 'dedicated.show',
        'store' => 'dedicated.store',
        'update' => 'dedicated.update',
        'destroy' => 'dedicated.destroy',
        'publish' => 'dedicated.publish',
        'unpublish' => 'dedicated.unpublish',
        'duplicate' => 'dedicated.duplicate'
    );
    private $view = array('create' => 'admin.dedicated.create',
        'edit' => 'admin.dedicated.edit',
        'index' => 'admin.dedicated.index',
        'show' => 'admin.dedicated.show');

    private $indexvariables = array(
        'title' => 'ALL WINDOWS Dedicated',
        'newitem' => 'NEW Dedicated ',
        'url' => 'dedicated'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW Dedicated ',
        'newitem' => 'NEW Dedicated ',
    );

    private $showvariables = array(
        'title' => 'Dedicated  DETAILS',
        'seeall' => 'SEE ALL WINDOWS Dedicated',
    );

    private $saveSuccess    = 'The dedicated  was successfully saved.';
    private $deletionSuccess = 'Dedicated  Deleted Successfully';
    private $updationSuccess = 'Dedicated  Updated Successfully';
    private $singlepostvar  = "dedicated";
    private $multipostvar   = "dedicated";
    private $indexpagination = 10;

    private $validation_rules = array(
        'name' => 'required',
        'logo'=> 'required|max:2048',
        'title' => 'required',
        'description' => 'required',
        'start_price' => 'required',
        'url_text' => 'required',
        'is_published'=> 'required',
        'keyword' => 'required'
    );

    private $update_validation_rules = array(
        'name' => 'required',
        'description' => 'required',
        'title' => 'required',
        'keyword' => 'required',
          'start_price' => 'required',
        'url_text' => 'required',
        'is_published'=> 'required',
    );

    private $formfields = array(

        'logo'=> array('name'  =>  'logo',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-6',
            'label' => 'Logo Image',
            'field_icon' => 'fa fa-file',
            'type'  =>  'file',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'logo',
                'placeholder' => 'Enter logo image here'
            )
        ),

        'name' => array('name'  =>  'name',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Dedicated RDP Name',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'name',
                'placeholder' => 'Enter Dedicated RDP name here',
                'required' => ''
            )
        ),
        'title' => array('name'  =>  'title',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Dedicated RDP Title',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'title',
                'placeholder' => 'Enter Dedicated RDP title here',
                'required' => ''
            )
        ),
        'keyword' => array('name'  =>  'keyword',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'SEO Keyword',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'textarea',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'keyword',
                'placeholder' => 'SEO Keyword',
                'required' => ''
            )
        ),
        'description' => array('name'  =>  'description',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Dedicated RDP Description Details',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'description',
                'placeholder' => 'Enter Dedicated RDP Description here',
                'required' => ''
            )
        ),

        'url_text' => array('name'  =>  'url_text',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Dedicated RDP URL Details',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'url_text',
                'placeholder' => 'Enter Dedicated RDP URL here',
                'required' => ''
            )
        ),

        'start_price' => array('name'  =>  'start_price',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Dedicated RDP Start Price',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'start_price',
                'placeholder' => 'Enter Dedicated RDP start price here',
                'required' => ''
            )
        ),

        'is_published'=> array('name'  =>  'is_published',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => ' Is Published ?',
            'field_icon' => 'fa fa-paper-plane',
            'type'  =>  'select',
            'default' => null,
            'choices' => array('0' => 'Save As Draft',
                '1' => 'Publish Now'),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'is_published',
                'placeholder' => 'Enter news message here',
                'required' => ''
            )
        ),
        'show_in_header' => array('name'  =>  'show_in_header',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Show in Header ?',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'checkbox',
            'default' => null,
            'checked' => true
        ),
        'show_in_footer' => array('name'  =>  'show_in_footer',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Show in Footer ?',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'checkbox',
            'default' => null,
            'checked' => true
        ),

    );

    private $indexfields = array(
        'id' => array('label' => '#'),
        'name'  => array('label' => 'Dedicated Name' ),
        'logo' => array('label' => 'Dedicated Logo' ),
        'start_price'  => array('label' => 'Dedicated Pricing' ),
        'created_at'=> array('label' => 'Created At'),
        'updated_at'=> array('label' => 'Updated At'),
    );

    private $showfields = array(
        'id' => array('label' => 'Dedicated RDP ID'),
        'name'  => array('label' => 'Dedicated RDP Name' ),
        'description'  => array('label' => 'Dedicated RDP Description' ),
        'logo' => array('label' => 'Dedicated RDP Logo' ),
        'url_text' => array('label' => 'URL Text'),
        'start_price'  => array('label' => 'Dedicated RDP Pricing' ),
        'created_at'=> array('label' => 'Created At'),
        'updated_at'=> array('label' => 'Updated At'),
        'show_in_header'=> array('label' => 'Show in Header'),
        'show_in_footer'=> array('label' => 'Show in Footer'),
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
        $post->show_in_header = $request->show_in_header == 'on' ? 1 : 0;
        $post->show_in_footer = $request->show_in_footer == 'on' ? 1 : 0;

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

        $category = DedicatedPlan::where('dedicated_id', $id)->paginate(5);
        return view($this->view['show'])->with('category', $category)
            ->with('fields', $fields)
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
        $fields['show_in_header']['checked'] = $post->show_in_header;
        $fields['show_in_footer']['checked'] = $post->show_in_footer;

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
        $post->show_in_header = $request->show_in_header == 'on' ? 1 : 0;
        $post->show_in_footer = $request->show_in_footer == 'on' ? 1 : 0;
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
        unset($newpost->id);
        unset($newpost->created_at);
        unset($newpost->updated_at);
        $newpost->name = $newpost->name.' Copy';
        $newpost->title = $newpost->title.' Copy';
        $newpost->url_text = $newpost->url_text.'-copy';
        $newpost->is_published = 0;
        $newpost->push();
        return redirect()->route($this->route['index']);
    }
}
