<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PhotosRequest;
use App\Photo;
use App\User;
use Storage;

class PhotosController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['create']);
    }

    public function getAll(){
      $photos = Photo::orderBy('id', 'desc')->paginate(30);

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
}
