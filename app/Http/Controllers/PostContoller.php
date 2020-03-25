<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;

class PostContoller extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'data.attributes.body' => ''
        ]);

        $post = request()->user()->posts()->create($data['data']['attributes']);

        return new PostResource($post);
    }
}
