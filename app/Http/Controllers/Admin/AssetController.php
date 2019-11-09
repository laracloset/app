<?php

namespace App\Http\Controllers\Admin;

use App\Asset;
use App\Http\Requests\StoreAsset;
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
            ->where('model', 'Asset')
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
     * @param \App\Http\Requests\StoreAsset $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreAsset $request)
    {
        $file = $request->file('file');
        $path = $file->store('assets');

        if (!$path) {
            abort(500);
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
        } else {
            abort(500);
        }

        return redirect('/admin/assets');
    }

    /**
     * Display the specified resource.
     *
     * @param Asset $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        return view('admin.asset.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Asset $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        return view('admin.asset.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\StoreAsset $request
     * @param Asset $asset
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreAsset $request, Asset $asset)
    {
        if (Storage::exists($asset->path) && !Storage::delete($asset->path)) {
            abort(500);
        }

        $file = $request->file('file');
        $path = $file->store('assets');

        if (!$path) {
            abort(500);
        }

        // We wonder if we should delete the old file or not...

        $asset->name = $file->getClientOriginalName();
        $asset->size = $file->getSize();
        $asset->type = $file->getMimeType();
        $asset->path = $path;

        if ($asset->save()) {
            flash('The asset has been saved.')->success();
        } else {
            abort(500);
        }

        return redirect('/admin/assets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Asset $asset
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Asset $asset)
    {
        if (Storage::exists($asset->path) && !Storage::delete($asset->path)) {
            abort(500);
        }

        if ($asset->delete()) {
            flash('The asset has been deleted.')->success();
            return back();
        }

        flash('The asset could not be deleted.')->error();
        return back();
    }

    /**
     * @param Asset $asset
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Asset $asset)
    {
        return Storage::disk()->download($asset->path);
    }
}
