<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->select('user_id','id', 'title', 'description', 'url', 'image_url', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $inputs = $request->validated();
        $inputs['user_id'] = $request->user()->id;
        try {
            $post = Post::create($inputs);
            return response()->json([
                'message' => 'Post Created',
                'post' => $post,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error Occured',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
