<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreArticle;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

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
        $categoryCollection = Category::treeList();

        return view('admin.article.create', compact('categoryCollection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreArticle $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreArticle $request)
    {
        DB::beginTransaction();

        try {

            $article = new Article([
                'title' => $request->get('title'),
                'slug' => $request->get('slug'),
                'body' => $request->get('body'),
                'state' => $request->get('state'),
            ]);
            $article->save();
            $article->categories()->sync($request->get('category'));

        } catch (\Exception $e) {

            DB::rollback();
            flash('The article could not been saved. Please, try again.')->error();

            return back()->withInput();
        }

        DB::commit();
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
        $article = Article::query()->findOrFail($id);

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
        $article = Article::query()->findOrFail($id);

        $categoryCollection = Category::treeList();

        return view('admin.article.edit', compact('article', 'categoryCollection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\StoreArticle $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreArticle $request, $id)
    {
        $article = Article::query()->findOrFail($id);

        DB::beginTransaction();

        try {

            $article->title = $request->get('title');
            $article->slug = $request->get('slug');
            $article->body = $request->get('body');
            $article->state = $request->get('state');
            $article->save();
            $article->categories()->sync($request->get('category'));

        } catch (\Exception $e) {

            DB::rollBack();
            flash('The article could not been saved. Please, try again.')->error();

            return back()->withInput();
        }

        DB::commit();
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
        $article = Article::query()->findOrFail($id);

        DB::beginTransaction();

        try {

            $article->delete();

        } catch (\Exception $e) {

            DB::rollBack();
            flash('The article could not be deleted.')->error();

            return back()->withInput();
        }

        DB::commit();
        flash('The article has been deleted.')->success();

        return back();
    }
}
