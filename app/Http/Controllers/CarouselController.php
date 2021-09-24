<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarouselModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $items = CarouselModel::all();
        return view('admin.carousel.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.carousel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, CarouselModel::rules());
        $data = new CarouselModel();
        $name = '';

        if ($request->has('nameimg')) {
            $n_file = $request->file("nameimg");
            $name = "carrousel_" . time() . "." . $n_file->guessExtension();
            $ruta = public_path("images/carousel/" . $name);
            copy($n_file, $ruta);
        } else {
            return back()->withErrors(trans('app.erro_store'));
        }
        $data->nameimg = "images/carousel/" . $name;
        $data->order = CarouselModel::all()->count() + 1;
        $data->save();

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
    public function edit($id): View
    {
        $item = CarouselModel::findOrFail($id);

        return view('admin.carousel.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = CarouselModel::findOrFail($id);
        $data = $request->all();
        if ($request->has('nameimg')) {
            $n_file = $request->file("nameimg");
            $name = "carrousel_" . time() . "." . $n_file->guessExtension();
            $ruta = public_path("images/carousel/" . $name);
            copy($n_file, $ruta);
            $data['nameimg'] = "images/carousel/" . $name;
        }
        $item->update($data);

        return redirect()->route(ADMIN . '.carousel.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CarouselModel::destroy($id);

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
