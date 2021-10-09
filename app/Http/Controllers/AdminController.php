<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = 1;
        $admins = User::whereUserTypes(2)->get();

        return view('backend.admin.admins.index', compact('count', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'string|unique:users',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'avatar' => 'nullable|max:1024',
            'password' => 'nullable|string|min:8',
        ]);

         //Handle Password
        if ($request['password']) {
            $password = Hash::make($request['password']);
        }else{
            $password = Hash::make($request['Earnkrypt2000']);
        }

        if($request->has('avatar')){
            $filename = date('d-M-Y-s') . '-'. pathinfo($request->avatar->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->avatar->getClientOriginalExtension();                 
            $avatar = $request->avatar->storeAs('avatars', $filename.'.'.$extension,'uploads'); 
        }

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'username' => $data['username'],
            'my_referral_code' => $data['username'],
            'password' => $password,
            'user_types' => 2,
            'avatar' => isset($avatar) ? $avatar : NULL,
         ]);

        return redirect(route('admins.index'))->with('message', 'Admin successfully added');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findorfail($id);
        return view('backend.admin.admins.update', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user = User::findorfail($id);

        if ($request['password']) {
            $password = Hash::make($request['password']);
        }else{
            $password = $user->password;
        }

        if($request->has('avatar')){
            //Unlink previous image
            if($user->avatar){
                if (file_exists(base_path() . '/uploads'.'/'.$user->avatar))
                unlink(base_path() . '/uploads'.'/'. $user->avatar);
            
            }
            $filename = date('d-M-Y-s') . '-'. pathinfo($request->avatar->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->avatar->getClientOriginalExtension();                 
            $user->avatar = $request->avatar->storeAs('avatars', $filename.'.'.$extension,'uploads'); 
   
        }
        $user->password = $password;
        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];

        $user->save();

        return back()->with('message', $request['name'].' updated Successful');
    
    }

    public function destroy($id)
    {
        //
    }
}
