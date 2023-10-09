<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\PostsRepository;
use App\Repositories\SyncRepository;

class TestingController extends Controller
{
    public function index()
    {
        $users = User::withWhereHas('roles', function ($q) {
            $q->where('name', 'User');
        })->get();
        dd($users);
    }
}
