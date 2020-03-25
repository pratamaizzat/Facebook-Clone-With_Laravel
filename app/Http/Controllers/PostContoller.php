<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use App\Post;

class PostContoller extends Controller
{

    public function index()
    {
        return new PostCollection(Post::all());
    }
    public function store()
    {
        $data = request()->validate([
            'data.attributes.body' => ''
        ]);

        $post = request()->user()->posts()->create($data['data']['attributes']);

        return new PostResource($post);
    }
}
