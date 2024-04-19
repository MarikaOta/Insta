<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    public function home()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        return view('home');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     private $post;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    #Get all the posts of the users the Auth User is following
    private function getHomePost()
    {
        $all_posts = $this->post->latest()->get(); // = all()
        $home_posts = []; //this array will hold the posts (of the users being followed and the post of currently logged-in users) in the homepage

        foreach($all_posts as $post){
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id)
            {
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = []; // a container that will hold every users

        foreach($all_users as $user)
        {
            if(!$user->isFollowed())
            {
                $suggested_users[]= $user;
            }
        }

        // return $suggested_users;
        return array_slice($suggested_users, 0, 5);
        #array_slice(x, y,z)
        #x -->name of the array
        #y -->offset|starting index
        #z -->number of length or how many
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        #SAME AS: SELECT * FROM posts ORDER BY created_at DESC

        // return view('users.home')
        //     ->with('all_posts', $all_posts);


        $home_posts = $this->getHomePost();
        $suggested_users = $this->getSuggestedUsers();
        return view('users.home')
                ->with('home_posts', $home_posts)
                ->with('suggested_users', $suggested_users);

    }

    public function search(Request $request){
        $users = $this->user->where('name', 'like', '%'.$request->search.'%')->get();
        return view('users.search')
                ->with('users', $users)
                ->with('search', $request->search);

        // We need create search.blade.php
    }
}
