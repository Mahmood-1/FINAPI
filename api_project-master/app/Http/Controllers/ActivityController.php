<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
// khhg
    // osrihjn
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activites = Activity->all();
        return parent::success($activites);
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
            'name' => 'required|min:3|unique:activities',
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }

        // Upload Images
        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'activity');
        }
        $activity = new Activity();
        $activity->fill($request->all());
        $result = $activity->save();
        if ( $result == 1) {
            return parent::success($activity, 201);
        } else {
            return parent::error('Something Went Wrong!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
