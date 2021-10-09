<?php

namespace App\Http\Controllers;

use App\Models\Medal;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MedalController extends Controller
{
     public function __construct()
    {
        $this->middleware(['admin'])->except('index');
    }

    public function index(){
       
        $count = 1;
        
        // dd($medals);
        if(auth()->user()->user_types != 1){
            $medals = Medal::with('users')->get(); 
            
            return view('backend.admin.medals.index', compact('medals', 'count'));
        }
        
    }

    public function create(){
        
        return view('backend.admin.medals.create');

    }

    public function edit(Medal $medal){
        
        return view('backend.admin.medals.update', compact('medal'));

    }

    public function store(Request $request){
        
        $data = $this->validate($request, [
            'title' => 'required',
            'value' => 'required|numeric',
            'description' => 'required',
            'icon' => 'required',

        ]);

        $filename = date('d-M-Y-s') . '-'. pathinfo($request->icon->getClientOriginalName(), PATHINFO_FILENAME);
            
        $extension = $request->icon->getClientOriginalExtension();                 
        $iconPath = $request->icon->storeAs('icons', $filename.'.'.$extension,'uploads'); 
 
        $medal = Medal::create([
            'title' => $data['title'],
            'value' => $data['value'],
            'description' => $data['description'],
            'icon' => $iconPath,
        ]);

        return redirect(route('medal.index'))->with('message', 'Medal added succesfully');

    }

    public function update(Medal $medal, Request $request){

        if($request->has('icon')){
            //Unlink previous image
            unlink( base_path() . '/uploads'.'/'. $medal->icon);

            $filename = date('d-M-Y-s') . '-'. pathinfo($request->icon->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->icon->getClientOriginalExtension();                 
            $medal->icon = $request->icon->storeAs('icons', $filename.'.'.$extension,'uploads');             
        }

        $medal->title = $request->title;
        $medal->value = $request->value;
        $medal->description = $request->description;
  
        $medal->save();
        
        return back()->with('message', 'Update successful');

    }

    public function destroy(Medal $medal){
        
        //check if there is an awardee
        if($medal->users->count() > 0){
            return back()->with('error', 'You cannot delete this badge because there are people who have claimed it');
        }
         if($medal->icon){
            unlink( base_path() . '/uploads'.'/'. $medal->icon);
        }
        
        $medal->delete();

        return back()->with('message', 'Delete Successfull');
        
    }

   
}
