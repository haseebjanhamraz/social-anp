<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\PostsRepository;
use App\Repositories\UsersRepository;
use App\Repositories\HashTagsRepository;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public $postsRepository;
    public $UsersRepository;
    public $tagsRepository;
    public function __construct(PostsRepository $postsRepository, UsersRepository $usersRepository, HashTagsRepository $tagsRepository)
    {
        $this->postsRepository = $postsRepository;
        $this->UsersRepository = $usersRepository;
        $this->tagsRepository = $tagsRepository;
    }


    public function index()
    {
        $users = User::withWhereHas('roles')->with('userAccounts.platform')->paginate(50);
        return view('users.index', ['users' => $users]);
    }

    public function dashboard()
    {
        $data['top_users'] = $this->UsersRepository->topUsers();
        $data['tags'] = $this->tagsRepository->trendingPosts()->groupBy('name');
        return view('users.dashboard', ['data' => $data]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|',
            'password-confirm' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('user.register.form')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('login')->with('message', 'You are registered successfully please wait until Admin approve your account !');
    }

    public function registerForm()
    {
        $user = session('user');
        return view('auth.register', compact('user'));
    }

    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true, 'message' => 'User Status Updated Successfully']);
    }
}
