<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')->with('user', $user);
    }

    public function showCollection($id)
    {
        $user = $this->user->findOrFail($id);
        $user_collections= $user->collections;
        // $users_collections = $this->user->findOrFail($id);
        return view('users.profile.collection')
                ->with('user', $user)
                ->with('user_collections', $user_collections);
    }

    public function edit($id)
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' =>'mimes:jpeg,jpg,png,gif|max:1048',
            'introduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        // $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if($request->avatar)
        {
            $user->avatar = 'data:image/'.$request->avatar->extension().';base64,'.base64_encode(file_get_contents($request->avatar));
        }
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);

        #Activity
        #1. add the error directives on the edit profile page
        #   Update the name, email, avatar,and introduction
        #2. Check if the user uploaded and avatar/image, if true then update the avatar
        #3. Save the update details
        # redirect to the show profile page
        # dont forget to create a route


    }

    public function updatePassword(Request $request)
    {
        $user = $this->user->findOrFail(Auth::user()->id);

        $request->validate([
            'new_password' => 'different:old_password|confirmed'
        ]);

        if(!password_verify($request->old_password, $user->password))
        {
            return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        $user->password = password_hash($request->new_password, PASSWORD_DEFAULT);
        $user->save();

        return redirect()->back()->with('status', 'Password changed successfully');

    }


    public function followers($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);

    }

    public function following($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }



}
