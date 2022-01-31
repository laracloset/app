<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::query()
            ->where('state', PostStatus::PUBLISHED)
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('post.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::query()
            ->where('state', PostStatus::PUBLISHED)
            ->findOrFail($id);

        return view('post.show', compact('post'));
    }
}
