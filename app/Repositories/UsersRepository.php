<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    public function countUsers()
    {
        return User::count();
    }

    public function topUsers($limit = 10)
    {
        return User::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get();
    }
}
