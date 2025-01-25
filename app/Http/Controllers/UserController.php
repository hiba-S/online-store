<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users' , ['users' => User::all() ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.profile' , ['user' => $user ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'image' => 'nullable|image',
            'password' => ['nullable', 'string', 'min:6',],
            'balance' => ['nullable', 'integer', 'min:0',],
        ]);

        if(!is_null($request->image)){
            $path = $user->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageFileName = time().".".$ext;
            $path = 'images/categories';
            $request->file('image')->move($path,$imageFileName);
            $imageFileNameWithPath = $path.'/'.$imageFileName;

        }else{
            $imageFileNameWithPath = $user->image;
        }

        $password = "";
        if($request->password){
            $password = bcrypt($request->password);
        }else{
            $password = $user->password;
        }

        if($request->balance or $request->balance=="0"){
            $user->balance =$request->balance;
        }
        if($request->role or $request->role=="0"){
            if($request->role!=$user->role){
                if(Auth::user()->can('changeRole', $user)){
                    $user->role =$request->role;
                }
            }
            
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageFileNameWithPath;
        $user->password = $password;
        
        $user->save();
        return view('user.profile' , ['user' => $user , 'message' =>'Profile Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();                

        return redirect()->route('dashboard')
        ->with('message', 'User Deleted successfully!');

    }

    public function balanceForm()
    {
        return view('cashier.increase-balance-form');
    }

    public function increasaBalance(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->balance += $request->balance;
            $user->save();
            
            return redirect()->route('dashboard')
            ->with('message', 'Balance Added successfully!');

        }else{
            return redirect()->route('dashboard')
            ->with('message', 'user does not exist!');
        }
    }
}
