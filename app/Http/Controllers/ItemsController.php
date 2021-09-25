<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Models\Category;
use App\Models\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $items = Item::orderBy('id', 'DESC')->get();
        $categories = Category::all();
        return view('admin.items.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, Item::rules());
        $data = $request->all();

        $name = "item_default.jpg";
        if ($image = $request->file('image')) {
            $name = "item_image_" . time() . "." . $image->guessExtension();
            $ruta = public_path("images/items/" . $name);
            copy($image, $ruta);
        }
        $data['image'] = "$name";
        Item::create($data);

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $item = Item::find($id);
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->validate($request, Item::rules(true, $id));

        $item = Item::findOrFail($id);
        $data = $request->all();

        if ($image = $request->file('image')) {
            $name = "item_image_" . time() . "." . $image->guessExtension();
            $ruta = public_path("images/items/" . $name);
            copy($image, $ruta);
            $data['image'] = "$name";
        }
        $item->update($data);

        return redirect()->route(ADMIN . '.items.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Item::destroy($id);
        return back()->withSuccess(trans('app.success_destroy'));
    }
}
