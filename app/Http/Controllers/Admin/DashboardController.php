<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $modelname = 'App\Models\Message';
    private $localname = 'dashboard';
    private $tablename = 'messages';
    private $route = array('show' => 'show',
        'index' => 'index'
    );

    private $indexvariables = array(
        'title' => 'DASHBOARD',
        'url' => 'dashboard',
        'urltomain' => '/'
    );

    private $view = array('index' => 'index',
        'show' => 'show');

    private $showvariables = array(
        'title' => 'MESSAGE DETAILS',
        'seeall' => 'SEE ALL MESSAGES',
    );

    private $multipostvar = "messages";
    private $singlepostvar = "message";
    private $indexpagination = 10;

    private $indexfields = array(
        'id' => array('label' => '#'),
        'name' => array('label' => 'Name'),
        'email' => array('label' => 'Email'),
        'subject' => array('label' => 'Subject'),
        'message' => array('label' => 'Message'),
        'updated_at' => array('label' => 'Updated At'),
    );


    private $showfields = array(
        'id' => array('label' => '#'),
        'name' => array('label' => 'Name'),
        'email' => array('label' => 'Email'),
        'subject' => array('label' => 'Subject'),
        'message' => array('label' => 'Message'),
        'updated_at' => array('label' => 'Updated At'),
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
            ->with('indexvar', $this->indexvariables);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fields = $this->showfields;
        $post = $this->modelname::find($id);
        if (!$post) {
            abort(404, 'Page not found.');
        }

        return view($this->view['show'])->with('fields', $fields)
            ->with('route', $this->route)
            ->with($this->singlepostvar, $post)
            ->with('showvar', $this->showvariables)
            ->with('singlepostvar', $this->singlepostvar);
    }
}
