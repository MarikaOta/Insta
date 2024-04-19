<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment; //This represents the Comments
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)
    {
        $request->validate(
        [
            'comment_body' . $post_id =>'required|max:150'
        ],
        [
            'comment_body' . $post_id . 'required' =>'You cannnot save an empty comment.',
            'comment_body' . $post_id . 'max' =>'The comment must not have more than 150 characters.'
        ]);

        $this->comment->body = $request->input('comment_body' . $post_id); //actual comments
        $this->comment->user_id = Auth::user()->id; //id of the owner of the comment
        $this->comment->post_id = $post_id;
        $this->comment->save();     //insert to the comments table

        return redirect()->back();

    }

    public function destroy($id)
    {
        $this->comment->destroy($id);

        return redirect()->back();
    }


}

