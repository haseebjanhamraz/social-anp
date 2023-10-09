<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PostsRepository
{
    public function getUserPostFromGraph($accessToken)
    {
        try {
            $response = Http::get("https://graph.facebook.com/v13.0/me/posts", [
                'access_token' => $accessToken,
            ]);
            if ($response->status() === 200) {
                return $response->json();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUserFacebookPosts($name)
    {
        $tags = Tag::whereHas('posts', function ($query) use ($name) {
            $query->whereHas('userAccount.platform', function ($platformQuery) use ($name) {
                $platformQuery->where('name', $name);
            });
        })->with(['posts.userAccount.platform'])->get();
        return $tags;
    }

    public function getPostsByPlatform($platform)
    {
        return Post::withWhereHas('userAccount.platform', function ($query) use ($platform) {
            $query->where('name', $platform);
        })->count();
    }

    public function chartData()
    {
        $results = DB::table('posts')
            ->selectRaw('MONTHNAME(posts.created_at) AS month_name, user_accounts.platform_id, SUM(1) AS post_count')
            ->join('user_accounts', 'posts.user_account_id', '=', 'user_accounts.id')
            ->groupBy('month_name', 'user_accounts.platform_id')
            ->get();

        // Initialize an associative array to store the formatted data
        $formattedData = [];

        // Loop through the results and aggregate the values for each month
        foreach ($results as $result) {
            $month = $result->month_name;
            $platform_id = $result->platform_id;
            $post_count = $result->post_count;

            // Initialize the month entry if it doesn't exist
            if (!isset($formattedData[$month])) {
                $formattedData[$month] = [
                    'w' => $month,
                    'x' => 0,
                    'y' => 0,
                    'z' => 0,
                ];
            }

            // Update the post_count based on the platform_id
            switch ($platform_id) {
                case '1':
                    $formattedData[$month]['x'] += $post_count;
                    break;
                case '2':
                    $formattedData[$month]['y'] += $post_count;
                    break;
                case '3':
                    $formattedData[$month]['z'] += $post_count;
                    break;
                    // Add more cases if needed for other platform_ids
            }
        }

        // Convert the associative array to a numeric array
        $finalData = array_values($formattedData);
        return $finalData;
    }
}
