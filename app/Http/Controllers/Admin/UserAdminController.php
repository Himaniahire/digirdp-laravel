<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Session, Validator, Auth;
use Storage;
use App\Http\Controllers\FileManager as File;
use App\Models\User;
class UserAdminController extends Controller
{
    private $uploadPath     = "uploads/user";

    private $modelname      = "App\Models\User";
    private $imageinputname = "user_image";

    private $route = array('create' => 'user.create',
        'edit' => 'user.edit',
        'index' => 'user.index',
        'show' => 'user.show',
        'store' => 'user.store',
        'update' => 'user.update',
        'destroy' => 'user.destroy',
    );
    private $view = array('create' => 'user.create',
        'edit' => 'user.edit',
        'index' => 'user.index',
        'show' => 'user.show');

    private $indexvariables = array(
        'title' => 'ALL USER',
        'newitem' => 'NEW USER',
        'url' => 'user'
    );

    private $createvariables = array(
        'title' => 'CREATE NEW USER',
        'newitem' => 'NEW USER',
    );

    private $showvariables = array(
        'title' => 'User DETAILS',
        'seeall' => 'SEE ALL USER',
    );

    private $saveSuccess    = 'The User was successfully saved.';
    private $deletionSuccess = 'User Deleted Successfully';
    private $updationSuccess = 'User Updated Successfully';
    private $singlepostvar  = "USER";
    private $multipostvar   = "USER";
    private $indexpagination = 10;

    private $validation_rules = array(
        'name' => 'required',
        'email'=> 'required|email',
        // 'password' => 'required'
    );

    private $update_validation_rules = array(
        'name' => 'required',
        'email'=> 'required|email',
       // 'password' => 'required'
    );
   //  private $uploadPath     = "uploads/blogs";
   private $formfields_edit = array(
        'name' => array('name'  =>  'name',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-6',
            'label' => 'User Name',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'question',
                'placeholder' => 'Enter user Name here',
                'required' => ''
            )
        ),

        'email' => array('name'  =>  'email',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-6',
            'label' => 'User email',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'answer',
                'placeholder' => 'Enter user email here',
                'required' => ''
            )
        ),

    );
    private $formfields = array(
        'name' => array('name'  =>  'name',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-6',
            'label' => 'User Name',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'question',
                'placeholder' => 'Enter user Name here',
                'required' => ''
            )
        ),

        'email' => array('name'  =>  'email',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-6',
            'label' => 'User Email',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'answer',
                'placeholder' => 'Enter user email here',
                'required' => ''
            )
        ),
        'password' => array('name'  =>  'password',
            // 'label_length' => 'col-lg-4',
            // 'field_length' => 'col-lg-6',
            'label' => 'User Password',
            'field_icon' => 'glyphicon glyphicon-pencil',
            'type'  =>  'text',
            'default' => null,
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'answer',
                'placeholder' => 'Enter user password here',
                'required' => ''
            )
        ),
    );

    private $indexfields = array(
        'id' => array('label' => '#'),
        'name'  => array('label' => 'Name' ),
        'email'  => array('label' => 'Email' ),
    );




    private $showfields = array(
        'id' => array('label' => 'User ID'),
        'name'  => array('label' => 'Name' ),
        'email'  => array('label' => 'Email' ),
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

    public function user_status(Request $request){
        User::where('id',$request->id)->update(['status'=>$request->status]);
        return redirect()->back()->with('msg','Status is changed');
    }




    public function processFile( $request, $update = 0)
    {

            if ($request->file('feature_image')->isValid())
            {
                $imginpname = $request->file('feature_image');

                if($update)
                {
                    File::delete($post->imginpname);
                }
                $imageName = time().'.'.$imginpname->getClientOriginalExtension();


                $request->file('feature_image')->move($this->uploadPath, $imageName);

                $pathToImage = $this->uploadPath.'/'.$imageName;
            }
        return $pathToImage;
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
        //dd($request);
        $post = new $this->modelname;

        //$this->processFile($post, $request);

        foreach ($this->formfields as $fieldname => $fieldvalue) {
            if(strcmp($fieldname, $this->imageinputname)) {
                if($fieldname == "password")
                {
                    $post->$fieldname = Hash::make($request->$fieldname);
                    $post->_password = $request->password;
                }
                else {
                    $post->$fieldname = $request->$fieldname;
                }
            }
        }

        $post->role = $request->role;
        $post->feature_image = $this->processFile($request);
        $post->permission = json_encode($request->permission);
        $post->deletep = $request->delete;


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
            ->with('showvar', $this->showvariables)->with('feature_image',$post->feature_image)
            ->with('uploadPath',url($this->uploadPath));

        // dd($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = $this->formfields_edit;
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
        foreach ($this->formfields as $fieldname => $fieldvalue) {
            if(strcmp($fieldname, $this->imageinputname)) {
                if($fieldname === "password")
                {
                    $post->$fieldname = Hash::make($request->$fieldname);
                    $post->_password = $request->password;
                }
                else {
                    $post->$fieldname = $request->$fieldname;
                }
            }
        }
         $post->role = $request->role;
        $post->permission = json_encode($request->permission);
        if($request->has('feature_iamge')):
            $post->feature_image = $this->processFile($request);
        endif;
        $post->deletep = $request->delete;
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
}
