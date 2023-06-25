<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $food = Food::all()->with('meals')->get();
        return parent::success($food);
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
            'name' => 'required|min:3|unique:foods',
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }

        // Upload Images
        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'food');
        }
        $food = new Food();
        $food->fill($request->all());
        $result = $food->save();
        if ( $result == 1) {
            return parent::success($food, 201);
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
            $food = Food::findOrFail($id)->with('meals')->get();
            return parent::success($food);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return parent::error('Food Not Found!');
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
            'name' => 'required|min:3|unique:foods,name,' . $id,
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'food');
        }

        try {
            $food = Food::findOrFail($id);
            $food->fill($request->all());
            $food->update();
            return parent::success($gym);
        } catch (\Exception) {
            return parent::error('Food Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $food = Food::findOrFail($id);
            $food->destroy($id);
            return parent::success("Gym $food->title Deleted Successfully");
        } catch (\Exception) {
            return parent::error('Food Not Found');
        }
    }

    public function add_meals(Request $request, $food_id)
    {
        try {
            $food = Food::findOrFail($food_id);

            $rules = [
                'name' => 'required|min:3',
                'photo' => 'mimes:jpg,png,jpeg,gif,svg',
                'desc' => 'required',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return parent::error($validation->errors());
            }

            if ($request->file('photo') != null) {
                $request['image'] = parent::image_upload($request->file('photo'), 'food');
            }

            DB::table('food_meals')->insert([
                'name' => $request->name,
                'image' => $request->image,
                'desc' => $request->desc,
                'food_id' => $food_id,
            ]);

            return parent::success("Food $food->title Meal Added Successfully");
        } catch (\Exception $e) {
            dd($e->getMessage());
            return parent::error('Food Not Found');
        }
    }
}
