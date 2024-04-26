<?php

namespace App\Http\Controllers;

#categories table is required
#posts table is required
use Illuminate\Support\Facades\Auth;  //authentication
use Illuminate\Http\Request;
use App\Models\Post; //posts table
use App\Models\Category; //categories table
use App\Models\Comment;

class PostController extends Controller
{
    #Define properties and constructor
    private $post;
    private $category;

    #constructor
    public function __construct(Post $post, Category $category, Comment $comment)
    {
        $this->post = $post;
        $this->category = $category;
        $this->comment = $comment;
    }

    public function create(){
        $all_categories = $this->category->all(); //retrieve all the categories
        #Same as : SELECT * FROM categories;

        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    # Note: (Request $request) holds the data coming form the form in the create post page
    public function store(Request $request)
    {
        #1. Validate the data first
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' =>'required|min:1|max:1000',
            'image' =>'required|mimes:jpeg,jpg,png,gif|max:1048',
            'posted_at' =>'date'
        ]);

        #2. Save our data into the database
        #Auth class is required
        $this->post->user_id = Auth::user()->id;  //the owner of the post
        $this->post->image = 'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->posted_at = $request->posted_at;
        $this->post->save();

        #3. Get the categories of the post and the category save it the PIVOT table(category_post)
        foreach($request->category as $category_id)
        {
            $category_post[] = ['category_id' => $category_id];
            #array
        }
        $this->post->categoryPost()->createMany($category_post);
        //categoryPost() : retriving Caregorypost model through post model

        #4. Go back homepage
        return redirect()->route('index');


    }

    #This is open show post page
    #The $id --->is the specific id of the post that we want to see
    #We will receive that
    public function show($id)
    {
        $post = $this->post->findOrFail($id);
        #SAME AS : SELECT * FROM posts WHERE id = $id;

        return view('users.posts.show')
                ->with('post', $post);

    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);
        #SAME AS : SELECT * FROM posts WHERE id = $id;

        #If the auth user is not the owner of the post, redirect them to the homepage
        if(Auth::user()->id != $post->user->id)
        {
            return redirect()->route('index');  //homepage
        }

        #get all the categories
        $all_categories = $this->category->all();

        #Get all the category IDs of this post, and save it in the array
        $selected_categories = [];
        foreach($post->categoryPost as $category_post)
        {
            $selected_categories[] = $category_post->category_id;
            //retrieve category_id from caregory_post table
        }

        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories',$selected_categories);

    }

    #This will do the actual updating of data
    public function update(Request $request, $id)
    {   #1. validate the data first
        $request->validate([
            'category' => 'array|between:1,3',
            'description' =>'required|min:1|max:1000',
            'image' =>'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Update the post details
        $post = $this->post->findOrFail($id); #Same as: SELECT * FROM posts WHERE id = $id
        $post->description = $request->description;

        #3. Check if there is new image uploaded
        if($request->image)
        {
            $post->image = 'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        }
        $post->save();

        #4. Delete all records from the category lists (category_post) related to this post
        $post->categoryPost()->delete();
        #Use the relationship Post::categoryPost() to select the records related to a post
        #SAME AS : DELETE FROM category_post WHERE post_id = $id

        #5. Save the new categories into the category_post PIVOT table
        foreach($request->category as $category_id)
        {
            $category_post[] = ['category_id' =>$category_id];
        }
        $post->categoryPost()->createMany($category_post);

        #5.Redirect the user to the show post (to confirm the update)
        return redirect()->route('post.show', $id);

    }

    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        $post->forceDelete();           #it will not serve in database

        #go to homepage
        return redirect()->route('index');
    }

}
