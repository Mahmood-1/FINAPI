<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodMeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class food_MealsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodM = FoodMeal::all();
        return view('dashboard.pages.foodM.index', [
            'foodM' => $foodM,
        ]);

    }



    public function create()
    {
        $foodM=new FoodMeal();
        $food = Food::all();
        return view('dashboard.pages.foodM.create', compact(['foodM','food']));
    }






    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
//            'name' => 'required|min:3|unique:foodM',
//            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
//            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }

        $data = $request->except('image');
        $data['image'] = $this->uploadImages($request, 'image');


        $foodM = FoodMeal::create($data);

        return redirect()->route('foodM.index')->with('success', 'foodM Created!');

    }


    public function show($id)
    {
        try {
            $foodM = FoodMeal::findOrFail($id)->with('meals')->get();
            return parent::success($foodM);
        } catch (\Exception $e) {

            return parent::error('FoodMeal Not Found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $foodM=FoodMeal::findOrFail($id);
        } catch (\Exception $e){
            return Redirect::route('foodM.index')
                ->with('info','Record is  not  Fount !');

        }

        return view('dashboard.pages.foodM.edit',compact(['foodM']));
    }


    public function update(Request $request, $id)
    {
        $rules = [
//            'name' => 'required|min:3|unique:foodM,name,' . $id,
//            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
//            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        $foodM = FoodMeal::findOrFail($id);
        $date = $request->except('image');

        $old_image =$foodM->image;
        $new_image = $this->uploadImages($request, 'image');
        if ($new_image) {
            $date['image'] = $new_image;
        } else {
            $date['image'] = $old_image;
        }

        $foodM->update($date);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('FoodMeal.index')->with('success', 'foodM Updated!');
    }


    public function destroy($id)
    {

            $FoodMeal = FoodMeal::findOrFail($id);
            $FoodMeal->destroy($id);
            return Redirect::route('foodM.index')
                ->with('wring','foodM deleted !');


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
