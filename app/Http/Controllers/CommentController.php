<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class CommentController extends Controller
{
    public function store(Request $request){
        $comment = Comment::create($request->all());

        return response([
            'type' => 'success',
            'user_name' => User::find($request->user_id)->name,
            'comment' => $request->comment,
            'time' =>$comment->created_at->diffForHumans(),
        ]);
    }
}
