<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $guarded = [];

    protected $dates = ['confirmed_at'];

    public static function friendship($userId)
    {
        //static function 
        /* memastikan bahwa  user_id sesuai dg
        authentic user id dan memastikan bahwa friend_id sama dengan user_id yang di pass dari User.php resource*/
        return (new static())
            ->where(function ($query) use ($userId) {
                return $query
                    ->where('user_id', auth()->user()->id)
                    ->where('friend_id', $userId);
            })
            ->orwhere(function ($query) use ($userId) { //berbeda kondisi dari yang diatas. berikut merupakan opposite dari yang diatas
                return $query
                    ->where('friend_id', auth()->user()->id)
                    ->where('user_id', $userId);
            })
            ->first();
    }
}
