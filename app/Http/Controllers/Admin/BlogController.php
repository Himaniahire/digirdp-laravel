<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileManager as File;
use App\Models\Category;
use App\Models\Post;
use Auth;
use Illuminate\Support\Str;
class BlogController extends Controller
{

    protected $thumb = [130, 140];
    protected $medium = [260, 200];
    protected $type = 'post';
    protected $status = 'publish';
 private $uploadPath     = "uploads/blogs";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Post::with('user')->get();
        //dd($blogs);
        return view( 'blog.index', ['title' => 'Blogs','blogs'=>$blogs, 'type' => $this->type]);
    }

    public function blog_delete(Request $request){
        Post::destroy($request->id);
        return redirect( route('blog.index') );
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

    public function update_flag(Request $req){

        if($req->status=="add"){
            Post::where('id',$req->article_id)->update(['flag'=>1]);
        }else{
            Post::where('id',$req->article_id)->update(['flag'=>0]);
        }

        return response()->json(['my'=>$data],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::where('parent', null)->get();
        return view('blog.create', ['title' => 'Create post', 'type' => $this->type, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token']);

        $input['slug'] = Str::slug( $request->title );
        //$input['excerpt'] = get_excerpt( $request->content, 40 );
        $input['status'] = 1;
        if( $request->hasFile('feature_image') ) {
            $input['feature_image'] = $this->processFile($request);
        }
        $input['post_by'] = Auth::id();
        Post::create($input);
        return redirect()->back()->with('post_msg', 'Post successfully created!');

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
        $array = array(
                    'title' => 'Edit post',
                    'type' => $this->type,
                    'post' => Post::find( $id )
                );
        return view('blog.edit', $array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function status_update(Request $request)
    {
        //dd($request->all());
        Post::where('id',$request->id)->update(['status'=>$request->status]);
        return redirect()->back()->with('post_msg', 'Status successfully updated!');
    }

    public function update(Request $request, $id)
    {

        $post = Post::findOrFail( $id );

        if( !$post )
            return redirect()->back()->with('post_err', 'Post not found!');

        $input = $request->except(['_token']);
        //dd($input);
        $input['slug'] = Str::slug( $request->title );
        //$input['excerpt'] = get_excerpt( $request->content, 40 );
        $input['status'] = 1;

        if( $request->hasFile('feature_image') ) {
           $input['feature_image'] = $this->processFile($request);
        }

        $input['post_by'] = Auth::id();
        unset($input['_method']);
        Post::where('id', $id)->update($input);

        return redirect()->back()->with('post_msg', 'Post successfully updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if( Post::where('id', $id)->delete() )
            return redirect()->back()->with('post_msg', 'Post deleted successfully!');

        return redirect()->back()->with('post_err', 'Post could not delete!');
    }


    private function upload( $image ) {

        $path = storage_path('app/public/post/');

        $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);

        $filename = $hashname . '-' . config('filesize.medium.0') . 'x' . config('filesize.medium.1') .
                    '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, $path, config('filesize.medium.0'), config('filesize.medium.1') );

        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        File::upload( $filename, $image, $path );

        return 'post/'.$filename;
    }
}
