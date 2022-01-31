<?php

namespace App\Http\Controllers;

use App\Models\Article;

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
            ->where('state', Article::PUBLISHED)
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('article.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::query()
            ->where('state', Article::PUBLISHED)
            ->findOrFail($id);

        return view('article.show', compact('article'));
    }
}
