<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;



class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gym = Gym::all();
        return view('dashboard.pages.gyms.index', [
            'gym' => $gym,
        ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gym=new Gym();
        return view('dashboard.pages.gyms.create',compact(['gym']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
//            'name' => 'required|min:3|unique:gyms',
//            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
//            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }

        $data = $request->except('image');
        $data['image'] = $this->uploadImages($request, 'image');


        $gyms = Gym::create($data);

        return redirect()->route('gym.index')->with('success', 'gym Created!');

    }


    public function show($id)
    {
        try {
            $gym = Gym::findOrFail($id)->with('meals')->get();
            return parent::success($gym);
        } catch (\Exception $e) {

            return parent::error('gyms Not Found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $gym=Gym::findOrFail($id);
        } catch (\Exception $e){
            return Redirect::route('gyms.index')
                ->with('info','Record is  not  Fount !');

        }

        return view('dashboard.pages.gyms.edit',compact(['gym']));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|unique:gyms,name,' . $id,
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            'desc' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return parent::error($validation->errors());
        }

        $gyms = Gym::findOrFail($id);
        $date = $request->except('image');

        $old_image =$gyms->image;
        $new_image = $this->uploadImages($request, 'image');
        if ($new_image) {
            $date['image'] = $new_image;
        } else {
            $date['image'] = $old_image;
        }

        $gyms->update($date);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('gym.index')->with('success', 'gyms Updated!');
    }


    public function destroy($id)
    {
        try {
            $gym = Gym::findOrFail($id);
            $gym->destroy($id);
            return Redirect::route('gym.index')
                ->with('wring','gyms deleted !');

        } catch (\Exception) {
            return parent::error('gym Not Found');
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
