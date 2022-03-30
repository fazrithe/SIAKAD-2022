<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\MMedia;

if (! function_exists('getUserName')) {
    function getUserName($user_id)
    {
        $user = DB::table('users')->where('id', $user_id)->first();
        return (isset($user->name) ? $user->name : '');
    }
}

if (! function_exists('getUserImage')) {
    function getUserImage($user_id)
    {
        $media = MMedia::where('model_id',$user_id)->first();
        return asset('/storage/1/6231476ff2f56_joko1.png');
    }
}
