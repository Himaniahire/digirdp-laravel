<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session, Validator, File, Auth;

class Configuration extends Controller
{
    private $modelname = "App\Models\Configuration";
    private $imageinputname = array('img_url');
    private $uploadPath     = "uploads/configuration";

    private $route = array(
        'update' => 'configuration.update',
        'index' => 'configuration.index',
    );
    private $view = array(
        'index' => 'admin.configuration.index');

    private $updationSuccess = 'Record updated Successfully';
    private $singlepostvar = "user_details";


    private $update_validation_rules = array(

    );

    private $formfields = array(
        'twitter' => array('name' => 'twitter',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Twitter Link',
            'field_icon' => 'fa fa-pencil',
            'type' => 'text',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'address',
                'placeholder' => 'Enter Twitter Link',
                'required' => ''
            )
        ),
        'fb' => array('name' => 'fb',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Facebook Link',
            'field_icon' => 'fa fa-pencil',
            'type' => 'text',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'address',
                'placeholder' => 'Enter Twitter Link',
                'required' => ''
            )
        ),
        'insta' => array('name' => 'insta',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Instagram Link',
            'field_icon' => 'fa fa-pencil',
            'type' => 'text',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'city',
                'placeholder' => 'Enter Instagram Link',
                'required' => ''
            )
        ),
        'github' => array('name' => 'github',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Github',
            'field_icon' => 'fa fa-file',
            'type' => 'text',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'state',
                'placeholder' => 'Enter Github Link'
            )
        ),
        'messenger' => array('name'  =>  'messenger',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Facebook Messenger Configuration',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'select',
            'default' => null,
            'choices' => array(
                '0' => 'Inactive',
                '1' => 'Active'
            ),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'messenger',
                'placeholder' => 'Enter Facebook Messenger Configuration',
                'required' => ''
            )
        ),
        'twak' => array('name'  =>  'twak',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Twak Chat Configuration',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'select',
            'default' => null,
            'choices' => array(
                '0' => 'Inactive',
                '1' => 'Active'
            ),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'messenger',
                'placeholder' => 'Twak Chat Configuration',
                'required' => ''
            )
        ),
        'google_analytics' => array('name'  =>  'google_analytics',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Google Analytics Configuration',
            'field_icon' => 'fa fa-pencil',
            'type'  =>  'select',
            'default' => null,
            'choices' => array(
                '0' => 'Inactive',
                '1' => 'Active'
            ),
            'extras'=> array('class' => 'form-control border-input',
                'id' => 'messenger',
                'placeholder' => 'Google Analytics Configuration',
                'required' => ''
            )
        ),
        'keywords' => array('name' => 'keywords',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'SEO Keywords',
            'field_icon' => 'fa fa-file',
            'type' => 'textarea',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'state',
                'placeholder' => 'Enter SEO Keywords'
            )
        ),
        'code_box_header' => array('name' => 'code_box_header',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Code Box Head',
            'field_icon' => 'fa fa-file',
            'type' => 'textarea',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'state',
                'placeholder' => 'Enter Code to add above head tag'
            )
        ),
        'code_box_footer' => array('name' => 'code_box_footer',
            'label_length' => 'col-lg-4',
            'field_length' => 'col-lg-8',
            'label' => 'Code Box Footer',
            'field_icon' => 'fa fa-file',
            'type' => 'textarea',
            'default' => null,
            'extras' => array('class' => 'form-control border-input',
                'id' => 'state',
                'placeholder' => 'Enter Code to add in footer tag'
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
