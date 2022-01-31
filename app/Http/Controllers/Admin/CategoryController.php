<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreOrUpdateCategory;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::query()
            ->orderBy('_lft', 'asc')
            ->get();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryCollection = Category::treeList();

        return view('admin.category.create', compact('categoryCollection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\StoreOrUpdateCategory $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreOrUpdateCategory $request)
    {
        $category = new Category([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'parent_id' => $request->get('parent_id'),
        ]);
        $category->save();

        flash('The category has been saved.')->success();

        return redirect('/admin/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::query()->findOrFail($id);

        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::query()->findOrFail($id);

        $categoryCollection = Category::treeList();

        return view('admin.category.edit', compact('category', 'categoryCollection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\StoreOrUpdateCategory $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreOrUpdateCategory $request, $id)
    {
        $category = Category::query()->findOrFail($id);

        $category->name = $request->get('name');
        $category->slug = $request->get('slug');
        $category->parent_id = $request->get('parent_id');
        $category->save();

        flash('The category has been saved.')->success();

        return redirect('/admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::query()->findOrFail($id);
        $category->delete();

        flash('The category has been deleted.')->success();

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function moveDown($id)
    {
        $category = Category::query()->findOrFail($id);
        if ($category->down()) {
            flash('Move down successfully.')->success();
        } else {
            flash('Could not move down.')->error();
        }

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function moveUp($id)
    {
        $category = Category::query()->findOrFail($id);
        if ($category->up()) {
            flash('Move up successfully.')->success();
        } else {
            flash('Could not move up.')->error();
        }

        return back();
    }
}
