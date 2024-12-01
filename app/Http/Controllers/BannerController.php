<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.banners.index')->with('banners',Banner::get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $banner = new Banner();
        $banner->image = $request->image->store('banners');
        $banner->url = $request->url;
        $banner->save();
        return redirect()->route('banners.index')->with(['success' => __('Added Successfuly')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard.banners.edit')->with('banner',Banner::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        if($request->image){
            $banner->image = $request->image->store('banners');
        }
        $banner->url = $request->url;
        $banner->save();
        return redirect()->back()->with(['success' => __('Edit Successfuly')]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $code = Banner::find($id);
        $code->delete();
        return redirect()->route('banners.index')->with(['success' => __('Deleted successfully')]);
    }
}
