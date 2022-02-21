<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CommentsRequest;
use App\Photo;
use App\User;
use App\Like;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['create']);
    }

    public function create(CommentsRequest $request, Photo $photo){
        $photo->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user_id
        ]);
    }

    public function getComments(Photo $photo){
        $comments = Comment::where('photo_id', $photo->id)->get();
        $comments->load('user');

        return $comments;
    }
}
