<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        
        return view('backend.admin.settings.update', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
       
        if($request->has('sitelogo')){

            //Upload new
            $newFileName = time() . rand(1111, 9999) . '.' . $request->sitelogo->getClientOriginalExtension();       
            $salespage_file = $request->sitelogo->storeAs('/images/site', $newFileName,'public'); 
           
            $request['logo'] = $newFileName;

        }else{
            $request['logo'] = $setting->logo;
        }

        if($request->has('sitefavicon')){

            //Upload new
            $newFileName = time() . rand(1111, 9999) . '.' . $request->sitefavicon->getClientOriginalExtension();       
            $salespage_file = $request->sitefavicon->storeAs('/images/site', $newFileName,'public'); 
            
            $request['favicon'] = $newFileName;

        }else{
            $request['favicon'] = $setting->favicon;
        }

        
        $setting->update($request->except(['sitelogo', 'sitefavicon']));

        return back()->with('message', 'Settings successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
