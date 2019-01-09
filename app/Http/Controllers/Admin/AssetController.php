<?php

namespace App\Http\Controllers\Admin;

use App\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::query()
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('admin.asset.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.asset.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('assets');

        if (!$path) {
            // TODO
        }

        $asset = new Asset([
            'model' => 'Asset',
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
            'path' => $path
        ]);

        if ($asset->save()) {
            flash('The asset has been saved.')->success();
            return redirect('/admin/assets');
        } else {
            flash('The asset could not be saved. Please try again.')->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $asset = Asset::query()->findOrFail($id);

        DB::beginTransaction();

        try {

            $deleted = $asset->delete() && Storage::disk()->delete($asset->path);

            if (!$deleted) {
                throw new \Exception();
            }

        } catch (\Exception $e) {

            DB::rollBack();
            flash('The asset could not be deleted.')->error();

            return back();
        }

        DB::commit();
        flash('The asset has been deleted.')->success();

        return redirect('/admin/assets');
    }
}
