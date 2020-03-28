<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Friend;
use App\Http\Resources\Friend as ResourcesFriend;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'friend_id' => ''
        ]);

        //temukan user yang mempunyai relasi table
        //mengunakan metode dibawah dikarenakan memerlukan exception error jika terdapat user yang invalid. digunakan untuk Handle Invalid user Friend Request
        try {
            User::findOrFail($data['friend_id'])
                ->friends()->attach(auth()->user());
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }


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
