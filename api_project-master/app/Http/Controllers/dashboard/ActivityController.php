<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
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
        return view('dashboard.pages.prices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.prices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('price.index')->with('success', 'price Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('dashboard.pages.prices.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        return redirect()->route('price.index')->with('success', 'prices Updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        return redirect()->route('price.index')->with('wring','foodM deleted !');


    }
}
