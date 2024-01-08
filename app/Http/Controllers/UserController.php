<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
class UserController extends Controller
{
    public function index(){
        
        $user = auth()->user();
        
        return view('admin.profile', ['user' => $user]);
    }


    public function updateProfile(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:512',
            'password' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:128',
            'company_website' => 'nullable|string|max:128',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',
            
            'bio.string' => 'The bio must be a string.',
            'bio.max' => 'The bio must not exceed 512 characters.',
            
            'password.string' => 'The password must be a string.',
            'password.max' => 'The password must not exceed 255 characters.',
            
            'company_name.string' => 'The company name must be a string.',
            'company_name.max' => 'The company name must not exceed 128 characters.',
            
            'company_website.string' => 'The company website must be a string.',
            'company_website.max' => 'The company website must not exceed 128 characters.',
        ]);
        
        $user = auth()->user();
        $data = $request->only(['name', 'bio', 'company_name', 'company_website']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);
        
        return view('admin.profile', ['user' => $user, 'success' => "Profile updated sucessfully"]);
    }

    public function updateProfilePicture (Request $request){
        
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024', // Max size is in kilobytes (1 MB)
        ], [
            'profile_pic.required' => 'Please select an image before saving.' ,
            'profile_pic.image' => 'The file must be an image.',
            'profile_pic.mimes' => 'The image must be of type: jpeg, png, jpg, gif.',
            'profile_pic.max' => 'The image size must not exceed 1 MB.',
        ]);
        
        $user = auth()->user();
        if ($request->hasFile('profile_pic')) {
            if ($user->profile_image && $user->profile_image !== '' ) {
                Storage::disk('public')->delete($user->profile_image);
            }
    
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            // print_r($path );
            // die();
            $user->profile_image = $path;
            $user->save();
        }

        return view('admin.profile', ['user' => $user, 'success' => "Profile updated sucessfully"]);
    }
    
}