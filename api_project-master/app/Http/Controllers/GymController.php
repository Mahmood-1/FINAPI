<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gym = Gym::all()->with('prices')->get();
        return parent::success($gym);
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
            'name' => 'required|min:3|unique:gyms',
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            'desc' => 'required',
            'location' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }

        // Upload Images
        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'gym');
        }
        $gym = new Gym();
        $gym->fill($request->all());
        $result = $gym->save();
        if ( $result == 1) {
            return parent::success($gym, 201);
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
            $gym = Gym::findOrFail($id)->with('prices')->get();
            return parent::success($gym);
        } catch (\Exception) {
            return parent::error('Gym Not Found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gym $gym)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|unique:gyms,name,' . $id,
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            'desc' => 'required',
            'location' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'gym');
        }

        try {
            $gym = Gym::findOrFail($id);
            $gym->fill($request->all());
            $gym->update();
            return parent::success($gym);
        } catch (\Exception) {
            return parent::error('Gym Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $gym = Gym::findOrFail($id);
            $gym->destroy($id);
            return parent::success("Gym $gym->title Deleted Successfully");
        } catch (\Exception) {
            return parent::error('Gym Not Found');
        }
    }

    public function add_prices(Request $request, $gym_id)
    {
        try {
            $gym = Gym::findOrFail($gym_id);

            $rules = [
                'name' => 'required|min:3',
                'photo' => 'mimes:jpg,png,jpeg,gif,svg',
                'desc' => 'required',
                'price' => 'required',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return parent::error($validation->errors());
            }

            if ($request->file('photo') != null) {
                $request['image'] = parent::image_upload($request->file('photo'), 'gym');
            }

            DB::table('gym_prices')->insert([
                'name' => $request->name,
                'image' => $request->image,
                'desc' => $request->desc,
                'price' => $request->price,
                'gym_id' => $gym_id,
            ]);

            return parent::success("Gym $gym->title Price Added Successfully");
        } catch (\Exception $e) {
            dd($e->getMessage());
            return parent::error('Gym Not Found');
        }
    }
}
