<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Http\Resources\Friend as ResourcesFriend;
use App\User;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'friend_id' => ''
        ]);

        //temukan user yang mempunyai relasi table
        User::find($data['friend_id'])
            ->friends()->attach(auth()->user());


        return new ResourcesFriend(
            //user_id belongs to auth user_id
            //cek friend_id = validate dari request data friend_id
            //->first() memastikan bahawa itu adalah model bukan dari collections
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $data['friend_id'])
                ->first()
        );
    }
}
