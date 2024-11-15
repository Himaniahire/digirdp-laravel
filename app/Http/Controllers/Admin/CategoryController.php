<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Image;
use Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        $category = Category::all();
        return view( 'category.index', ['title' => 'All categories','category'=>$category] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'category.create', ['title' => 'Create category'] );
    }

    public function status_update(Request $request)
    {
        //dd($request->all());
        Category::where('id',$request->id)->update(['status'=>$request->status]);
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
                        // 'description' => $request->description,
                       // 'feature_image' => $filename
                    );

        if( Category::create( $array ) )
            return redirect()->back()->with('post_msg', 'Category created successfully!');

        return redirect()->back()->with('cat_err', 'Category could not create!');
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

        $category = Category::find($id);
        return view( 'admin.category/edit', ['title' => 'Edit category', 'category' => $category] );
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
        if( $request->hasFile( 'image' ) ) {
            $image = $request->file('image');
            $filename = $this->upload( $image );
        }
        else {
            $filename = $request->filename;
        }

        $array = array(
                        'name' => $request->name,
                        'slug' => Str::slug($request->name),
                        'parent' => $request->parent,
                        // 'description' => $request->description,
                       // 'feature_image' => $filename
                    );

        if( Category::where('id', $id)->update( $array ) )
            return redirect()->back()->with('post_msg', 'Category updated successfully!');

        return redirect()->back()->with('post_msg', 'Category could not update!');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if( Category::where('id', $id)->delete() )
            return redirect()->back()->with('cat_msg', 'Category deleted successfully!');

        return redirect()->back()->with('cat_err', 'Category could not delete!');
    }
}
