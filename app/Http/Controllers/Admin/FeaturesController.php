<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use File;


class FeaturesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $features_card = DB::table('features_card')
                    ->orderBy('card_id', 'desc')
                    ->join('features_card_category', 'features_card.category_id', '=', 'features_card_category.category_id')
                    ->get();


        $features_count = DB::table('features_card')->count();


        return view('features.index')
            ->with('features_card', $features_card)
            ->with('features_count', $features_count);
    }

    public function create()
    {
        $feature_category = DB::table('features_card_category')->get();

        return view('features.create')
        ->with('feature_category', $feature_category);
    }


    public function show($id)
    {
        $features_card = DB::table('features_card')
                    ->join('features_card_category', 'features_card.category_id', '=', 'features_card_category.category_id')
                    ->where('card_id', $id)
                    ->first();

        return view('features.show')
        ->with('features_card', $features_card);
    }

    public function store(Request $request)
    {
        // return $request->all();

        $image = $request->file('card_image');
        $imageName = time().'.'.$image->getClientOriginalExtension();

        $image->move('uploads/features', $imageName);
        $pathToImage = 'uploads/features'.'/'.$imageName;



        $id = DB::table('features_card')
            ->insertGetId([
                'card_title' => $request->card_title,
                'card_content' => $request->card_content,
                'category_id' => $request->category_id,
                'card_image' => $pathToImage
            ]);

        return redirect()->route('features.show', $id);
    }

    public function edit($id)
    {
        $features = DB::table('features_card')
                ->join('features_card_category', 'features_card.category_id', '=', 'features_card_category.category_id')
                ->where('card_id', $id)->first();

        $feature_category = DB::table('features_card_category')->get();

        return view('features.edit')
            ->with('features', $features)
            ->with('feature_category', $feature_category);
    }

    public function update(Request $request, $id)
    {
        $image = $request->file('card_image');

        $updates = [
            'card_title' => $request->card_title,
            'card_content' => $request->card_content,
            'category_id' => $request->category_id
        ];

        if($image)
        {
            $data = DB::table('features_card')->where('card_id', $id)->first();
            File::delete($data->card_image);
            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move('uploads/features', $imageName);
            $pathToImage = 'uploads/features'.'/'.$imageName;
            $updates['card_image'] = $pathToImage;
        }

        $insert_feature = DB::table('features_card')
            ->where('card_id', $id)
            ->update($updates);

        return redirect()->route('features.show', $id);
    }


    public function destroy($id)
    {
        $data = DB::table('features_card')->where('card_id', $id)->first();

        File::delete($data->card_image);

        DB::table('features_card')->where('card_id', $id)->delete();
        Session::flash('success', 'Feature Deleted Success !');

        return redirect()->route('features.index');
    }
}
