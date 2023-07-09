<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $food = Food::all();
        return view('dashboard.pages.foods.index', [
            'foods' => $food,
        ]);

    }

    public function index2()
    {
        return view('dashboard.dashboard');


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $foods=new Food();
        return view('dashboard.pages.foods.create',compact(['foods']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|unique:Foods',
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }

        $data = $request->except('image');
        $data['image'] = $this->uploadImages($request, 'image');


        $foods = Food::create($data);

        return redirect()->route('food.index')->with('success', 'Food Created!');

    }


    public function show($id)
    {
        try {
            $food = Food::findOrFail($id)->with('meals')->get();
            return parent::success($food);
        } catch (\Exception $e) {

            return parent::error('Food Not Found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $foods=Food::findOrFail($id);
        } catch (\Exception $e){
            return Redirect::route('foods.index')
                ->with('info','Record is  not  Fount !');

        }

        return view('dashboard.pages.foods.edit',compact(['foods']));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|unique:Foods,name,' . $id,
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        $foods = Food::findOrFail($id);
        $date = $request->except('image');

        $old_image =$foods->image;
        $new_image = $this->uploadImages($request, 'image');
        if ($new_image) {
            $date['image'] = $new_image;
        } else {
            $date['image'] = $old_image;
        }

        $foods->update($date);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('food.index')->with('success', 'Foods Updated!');
    }


    public function destroy($id)
    {
        try {
            $food = Food::findOrFail($id);
            $food->destroy($id);
            return Redirect::route('food.index')
                ->with('wring','foods deleted !');

        } catch (\Exception) {
            return parent::error('Food Not Found');
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
            return parent::error('Food Not Found');
        }
    }


}
