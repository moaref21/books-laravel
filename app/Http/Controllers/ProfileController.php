<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        
        return view('profile',compact('user'));
    }

    public function update(User $user ,Request $request)
    {

        $userId = auth()->user()->id;
        $data = request()->validate(
            [
                'name' => 'required|min:3',
                'email' => ['required', Rule::unique('users')->ignore($userId)],
                'password' => 'nullable|confirmed|min:8',
                'image' => 'mimes:jpeg,jpg,png'
                ]
            );

        if (request()->has('password')) {
            $data['password'] = Hash::make(request('password'));
        }

        if ($request->has ('image')) {
           
            $user->image=$image=request('image')->store('users','public');
           
        }
        
        User::findorfail($userId)->update($data);
        return redirect('/profile');

    }

    public function uploadFile($file){
        $dest=public_path()."storage/images/";

    
        $filename= time()."_".$file->getClientOriginalName();
        $file->move($dest,$filename);
        return $filename;


    }
}
