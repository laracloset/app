<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::query()
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article([
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'body' => $request->get('body'),
            'state' => $request->get('state'),
        ]);
        $article->save();

        flash('The article has been saved.')->success();

        return redirect('/admin/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::query()->find($id);

        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::query()->find($id);

        return view('admin.article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::query()->find($id);

        $article->title = $request->get('title');
        $article->slug = $request->get('slug');
        $article->body = $request->get('body');
        $article->state = $request->get('state');
        $article->save();

        flash('The article has been saved.')->success();

        return redirect('/admin/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::query()->find($id);
        $article->delete();

        flash('The article has been deleted.')->success();

        return redirect('/admin/articles');
    }
}
