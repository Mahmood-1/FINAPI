<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = post::all();
        return parent::success($post);
    }

    public function get_by_gender($gender)
    {
        $post = post::where('gender', $gender)->get();
        return parent::success($post);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:8|max:128',
            'body' => 'required|min:8|max:128',
            'video' => 'mimes:mp4',
            'audio' => 'mimes:mp3',
            'photo' => 'required|mimes:jpg,png,jpeg,gif,svg',
            'category' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        $post = new post();

        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'users');
        }
        if ($request->file('show') != null) {
            $request['video'] = parent::image_upload($request->file('video'), 'posts');
        }
        if ($request->file('sound') != null) {
            $request['audio'] = parent::image_upload($request->file('sound'), 'posts');
        }
        
        $post->fill($request->all());
        $result = $post->save();

        if ($result) {
            return parent::success($post, 201);
        } else {
            return parent::error('Something Went Wrong!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = post::findOrFail($id);
            return parent::success($post);
        } catch (\Exception) {
            return parent::error('Post Not Found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        $rules = [
            'title' => 'required|min:8|max:128',
            'body' => 'required|min:8|max:128',
            'video' => 'mimes:mp4',
            'audio' => 'mimes:mp3',
            'photo' => 'required|mimes:jpg,png,jpeg,gif,svg',
            'category' => 'required|in:Health Tips, Fitness, Audio, Video'
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'users');
        }
        if ($request->file('show') != null) {
            $request['video'] = parent::image_upload($request->file('video'), 'posts');
        }
        if ($request->file('sound') != null) {
            $request['audio'] = parent::image_upload($request->file('sound'), 'posts');
        }

        try {
            $post = post::findOrFail($id);
            $post->fill($request->all());
            $post->update();
            return parent::success($post);
        } catch (\Exception) {
            return parent::error('Post Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = post::findOrFail($id);
            $post->destroy($id);
            return parent::success("Post $post->title Deleted Successfully");
        } catch (\Exception) {
            return parent::error('Post Not Found');
        }
    }
}
