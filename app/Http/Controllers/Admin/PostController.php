<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreOrUpdatePost;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

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
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryCollection = Category::treeList();

        return view('admin.post.create', compact('categoryCollection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\StoreOrUpdatePost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreOrUpdatePost $request)
    {
        $saved = DB::transaction(function () use ($request) {

            $post = new Post([
                'title' => $request->get('title'),
                'slug' => $request->get('slug'),
                'body' => $request->get('body'),
                'state' => $request->get('state'),
            ]);
            $post->save();
            $post->categories()->sync($request->get('category'));

            return true;
        });

        if ($saved) {
            flash('The post has been saved.')->success();

            return redirect(route('admin.posts.index'));
        }

        flash('The post could not been saved. Please, try again.')->error();
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categoryCollection = Category::treeList();

        return view('admin.post.edit', compact('post', 'categoryCollection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\StoreOrUpdatePost $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreOrUpdatePost $request, Post $post)
    {
        $saved = DB::transaction(function () use ($post, $request) {

            $post->title = $request->get('title');
            $post->slug = $request->get('slug');
            $post->body = $request->get('body');
            $post->state = $request->get('state');
            $post->save();
            $post->categories()->sync($request->get('category'));

            return true;
        });

        if ($saved) {
            flash('The post has been saved.')->success();

            return redirect('/admin/posts');
        }

        flash('The post could not been saved. Please, try again.')->error();

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $deleted = DB::transaction(function() use ($post) {
            $post->delete();

            return true;
        });

        if ($deleted) {
            flash('The post has been deleted.')->success();
            return back();
        }

        flash('The post could not be deleted.')->error();
        return back()->withInput();
    }
}
