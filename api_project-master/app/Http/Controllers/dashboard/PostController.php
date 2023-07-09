<?php

namespace App\Http\Controllers\dashboard;


namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = post::all();
        return view('dashboard.pages.posts.index', [
            'post' => $post,
        ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post=new post();
        return view('dashboard.pages.posts.create',compact(['post']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
//            'name' => 'required|min:3|unique:posts',
//            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
//            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }

        $data = $request->all();
        $data['image'] = $this->uploadImages($request, 'image');


        $posts = post::create($data);

        return redirect()->route('fitness.index')->with('success', 'post Created!');

    }


    public function show($id)
    {
        try {
            $post = post::findOrFail($id)->with('meals')->get();
            return parent::success($post);
        } catch (\Exception $e) {

            return parent::error('Fitness Not Found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $post=post::findOrFail($id);
        } catch (\Exception $e){
            return Redirect::route('posts.index')
                ->with('info','Record is  not  Fount !');

        }

        return view('dashboard.pages.posts.edit',compact(['post']));
    }


    public function update(Request $request, $id)
    {
        $rules = [
//            'name' => 'required|min:3|unique:posts,name,' . $id,
//            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
//            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        $posts = post::findOrFail($id);
        $date = $request->all();
        $posts->update($date);
        return redirect()->route('fitness.index')->with('success', 'posts Updated!');
    }


    public function destroy($id)
    {
        try {
            $post = post::findOrFail($id);
            $post->destroy($id);
            return Redirect::route('fitness.index')
                ->with('wring','posts deleted !');

        } catch (\Exception) {
            return parent::error('post Not Found');
        }
    }
    public function uploadImages(Request $request, $fieldName){
        if (!$request->hasFile($fieldName)) {
            return;
        }
        $file = $request->file($fieldName);
        $path = $file->store('uploads', ['disk' => 'public']);
        return Storage::url($path);
    }




}
