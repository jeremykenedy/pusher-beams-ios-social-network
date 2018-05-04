<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\PhotoComment;

class PhotoCommentController extends Controller
{
    public function index(Request $request)
    {
        $photo = Photo::with('comments')->findOrFail($request->route('photo'));

        return response()->json(['data' => $photo->comments]);
    }

    public function store(Request $request, Photo $photo)
    {
        $data = $request->validate(['comment' => 'required|string|between:2,500']);

        $comment = PhotoComment::create([
            'photo_id' => $photo->id,
            'comment' => $data['comment'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['status' => 'success', 'data' => $comment->load('user')]);
    }
}
