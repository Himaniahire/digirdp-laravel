<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use Image;
use Auth;
use Illuminate\Support\Str;

class LocationController extends Controller
{

    protected $thumb = [270, 225];
    protected $medium = [550, 360];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Location::all();
        return view( 'location.index', ['title' => 'All Locations','category'=>$category] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'location.create', ['title' => 'Create Locations'] );
    }

    public function status_update(Request $request)
    {
        //dd($request->all());
        Location::where('id',$request->id)->update(['status'=>$request->status]);
        return redirect()->back()->with('post_msg', 'Status successfully updated!');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $filename = '';
        // if( $request->hasFile( 'image' ) ) {
        //     $image = $request->file('image');
        //     $filename = $this->upload( $image );
        // }

        $array = array(
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'parent' => $request->parent,
                        'iframe' => $request->iframe,
                        // 'description' => $request->description,
                       // 'feature_image' => $filename
                    );

        if( Location::create( $array ) )
            return redirect()->back()->with('post_msg', 'Location created successfully!');

        return redirect()->back()->with('cat_err', 'Location could not create!');
    }



    private function upload( $image ) {

        $path = storage_path('app/public/category/');

        $hashname = md5($image->getClientOriginalName().time());
        $filename = $hashname . '-' . config('filesize.thumbnail.0') . 'x' . config('filesize.thumbnail.1') . '.' . $image->getClientOriginalExtension();
        File::upload($filename, $image, $path, config('filesize.thumbnail.0'),config('filesize.thumbnail.1'));

        $filename = $hashname . '-' . config('filesize.medium.0') . 'x' . config('filesize.medium.1') .
                    '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, $path, config('filesize.medium.0'), config('filesize.medium.1') );

        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, $path );

        return 'category/'.$filename;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = Location::find($id);
        return view( 'location/edit', ['title' => 'Edit locations', 'category' => $category] );
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
        $filename = '';


        $array = array(
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'parent' => $request->parent,
                        'iframe' => $request->iframe,
                    );

        if( Location::where('id', $id)->update( $array ) )
            return redirect()->back()->with('post_msg', 'Location updated successfully!');

        return redirect()->back()->with('post_msg', 'Location could not update!');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if( Location::where('id', $id)->delete() )
            return redirect()->back()->with('cat_msg', 'Location deleted successfully!');

        return redirect()->back()->with('cat_err', 'Location could not delete!');
    }
}
