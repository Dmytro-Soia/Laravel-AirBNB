<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilePicture extends Model
{
    protected $fillable = [
        'user_id',
        'prof_pic',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public static function savePic($file, $user) {
        $picName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('images', $file, $picName);
        $photo = new ProfilePicture();
        $photo->prof_pic = $picName;
        $user->prof_pic()->save($photo);
    }
}
