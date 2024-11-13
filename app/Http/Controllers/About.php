<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session, Validator, File, Auth;

class About extends Controller
{
    private $modelname = "App\Models\About";
    private $imageinputname = array('img_url');
    private $uploadPath     = "uploads/about";

    private $route = array(
        'update' => 'about.update',
        'index' => 'about.index',
    );
    private $view = array(
        'index' => 'admin.about.index');

    private $updationSuccess = 'Record updated Successfully';
    private $singlepostvar = "user_details";


    private $update_validation_rules = array(
        'heading' => 'required',
        'description' => 'required',
        'About' => 'required',
    );

    private $formfields = array(
        'heading' => array('name' => 'heading',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Heading',
            'field_icon' => 'fa fa-pencil',
            'type' => 'text',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'address',
                'placeholder' => 'Enter Heading',
                'required' => ''
            )
        ),
        'description' => array('name' => 'description',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Description',
            'field_icon' => 'fa fa-pencil',
            'type' => 'text',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'city',
                'placeholder' => 'Enter Description',
                'required' => ''
            )
        ),
        'About' => array('name' => 'About',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'About',
            'field_icon' => 'fa fa-file',
            'type' => 'textarea',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'state',
                'placeholder' => 'Enter About'
            )
        ),

    );

    private $showfields = array(
        'id' => array('label' => '#'),
        'heading' => array('label' => 'Heading'),
        'description' => array('label' => 'Description'),
        'About' => array('label' => 'About'),
    );

    /**
     *  Create a new controller instance.
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
        $fields = $this->formfields;
        $post = $this->modelname::find(1);
        return view($this->view['index'])->with($this->singlepostvar, $post)
            ->with('route', $this->route)
            ->with('fields', $fields)
            ->with('singlepostvar', $this->singlepostvar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imageName = null;
        $post = $this->modelname::find($id);
        $updaterules = $this->update_validation_rules;

        $this->validate($request, $updaterules);

        if (!empty($this->imageinputname)) {

            $imginpnames = $this->imageinputname;

            foreach ($imginpnames as $imginpname) {

                if ($request->hasFile($imginpname)) {
                    if ($request->file($imginpname)->isValid()) {
                        Storage::disk('public_uploads')->delete($post->imginpname);
                        $imageName = time() . rand(5000, 10000) . '.' . $request->$imginpname->getClientOriginalExtension();
                        $request->$imginpname->move($this->uploadPath, $imageName);
                        $post->$imginpname = $this->uploadPath . '/' . $imageName;
                    } else {
                        Session::flash('warning', 'Uploaded file is not valid');
                        return back()->withErrors($validator)->withInput();
                    }
                }

            }

        }

        foreach ($this->formfields as $fieldname => $fieldvalue) {
            if (!in_array($fieldname, $this->imageinputname))
                $post->$fieldname = $request->$fieldname;
        }
        $post->save();

        return redirect()->route($this->route['index'], $post->id);
    }
}
