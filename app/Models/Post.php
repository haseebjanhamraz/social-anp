<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'content' => 'object',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_has_tags');
    }

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_account_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
