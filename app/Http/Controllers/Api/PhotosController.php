<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PhotosRequest;
use App\Photo;
use App\User;
use App\Like;
use App\Comment;
use Storage;

class PhotosController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['create', 'likePhoto', 'unlikePhoto']);
    }

    public function getAll(){
      $photos = Photo::orderBy('id', 'desc')->paginate(30);
      $photos->load('user');

      return $photos;
    }

    public function create(PhotosRequest $request){
      if($request->file()){
          $image = $request->file('path');
          $path = Storage::disk('s3')->putFile('/', $image, 'public');

          $user = User::find($request->input('user_id'));
          $res = $user->photos()->create([
              'path' => Storage::disk('s3')->url($path)
          ]);

          return $res->id;
      }
    }

    public function getLikes(Photo $photo){
      return $photo->likes->count();
    }

    public function likePhoto(User $user, Photo $photo){
      Like::create([
        'user_id' => $user->id,
        'photo_id' => $photo->id
      ]);
    }

    public function unlikePhoto(User $user, Photo $photo){
      $like = Like::where('user_id', $user->id)->where('photo_id', $photo->id);
      $like->delete();
    }

    public function checkLiked(User $user, Photo $photo){
      $res = Like::where('user_id', $user->id)->where('photo_id', $photo->id)->exists();

      return (string) $res;
    }

    public function show(Photo $photo){
      $photo->load('user', 'comments');
      $comments = Comment::where('photo_id', $photo->id)->get();
      $comments->load('user');

      return [$photo, $comments];
    }
}
