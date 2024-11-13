<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;

class FAQController extends Controller
{
    private $uploadPath     = "uploads/faq";
    private $modelname      = "App\Models\FAQ";
    private $localname      = "faq";
    private $tablename      = "faq";
    private $imageinputname = "faq_image";
    private $publishfield   = "is_published";

    private $route = array('create' => 'faq.create',
        'edit' => 'faq.edit',
        'index' => 'faq.index',
        'show' => 'faq.show',
        'store' => 'faq.store',
        'update' => 'faq.update',
        'destroy' => 'faq.destroy',
        'publish' => 'faq.publish',
        'unpublish' => 'faq.unpublish'
    );
    private $view = array('create' => 'admin.faq.create',
        'edit' => 'admin.faq.edit',
        'index' => 'admin.faq.index',
        'show' => 'admin.faq.show');

    private $indexvariables = array(
        'title' => 'ALL FAQ',
        'newitem' => 'NEW FAQ',
        'url' => 'faq'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW FAQ',
        'newitem' => 'NEW FAQ',
    );

    private $showvariables = array(
        'title' => 'FAQ DETAILS',
        'seeall' => 'SEE ALL FAQ',
    );

    private $saveSuccess    = 'The FAQ was successfully saved.';
    private $deletionSuccess = 'FAQ Deleted Successfully';
    private $updationSuccess = 'FAQ Updated Successfully';
    private $singlepostvar  = "FAQ";
    private $multipostvar   = "faq";
    private $indexpagination = 10;

    private $validation_rules = array(
        'question' => 'required',
        'answer'=> 'required|max:2048',
    );

    private $update_validation_rules = array(
        'question' => 'required',
        'answer'=> 'required|max:2048',
    );

    private $formfields = array(


        'question' => array('name'  =>  'question',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'FAQ Question',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'question',
                'placeholder' => 'Enter FAQ Question here',
                'required' => ''
            )
        ),

        'answer' => array('name'  =>  'answer',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'FAQ Answer',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'textarea',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'answer',
                'placeholder' => 'Enter FAQ Answer here',
                'required' => ''
            )
        ),

        'category_id' => array('name'  =>  'category_id',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Select Category',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'select',
            'default' => null,
            // 'choices' => array(
            //     'Windows RDP' => 'Windows RDP',
            //     'Web Hosting' => 'Web Hosting',
            //     'Cloud VPS' => 'Cloud VPS',
            //     'Dedicated Server' => 'Dedicated Server',
            //     'Others' => 'Others'
            // ),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'category_id',
                'placeholder' => 'Select Category',
                'required' => ''
            )
        ),

    );

    private $indexfields = array(
        'id' => array('label' => '#'),
        'question'  => array('label' => 'Question' ),
        'category_name'  => array('label' => 'Category' ),
        // 'created_at'=> array('label' => 'Created At'),
        'updated_at'=> array('label' => 'Updated At'),
    );




    private $showfields = array(
        'id' => array('label' => 'FAQ ID'),
        'question'  => array('label' => 'Question' ),
        'answer'  => array('label' => 'Answer' ),
        'category_name' => array('label' => 'Category')
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
        $posts = $this->modelname::orderBy('id', 'desc')->join('faq_category', 'f_a_q_s.category_id', '=', 'faq_category.category_id')->paginate($this->indexpagination);
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

        $category_choices = DB::table('faq_category')->get();
        foreach($category_choices as $cc)
        {
            $choices[(string)$cc->category_id] = $cc->category_name;
        }

        $fields['category_id']['choices'] = $choices;

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
        $post->post_id = $request->post_id ?? 0;
        $post->page_id = $request->page_id ?? 0;
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
        $post = $this->modelname::join('faq_category', 'f_a_q_s.category_id', '=', 'faq_category.category_id')
            ->find($id);
        // dd($post);

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
     * 
     */
    public function edit($id)
    {
        $fields = $this->formfields;

        $category_choices = DB::table('faq_category')->get();
        foreach($category_choices as $cc)
        {
            $choices[(string)$cc->category_id] = $cc->category_name;
        }

        $fields['category_id']['choices'] = $choices;


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
        $post->post_id = $request->post_id ?? 0;
        $post->page_id = $request->page_id ?? 0;
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
        // if(!empty($this->imageinputname))
        // {
        //     $inpname = $this->imageinputname;
        //     File::delete($post->$inpname);
        // }
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
