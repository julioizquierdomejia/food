<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Http\Requests\StoreDishRequest;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dishes = Dish::all();

        return view('admin.dishes.index', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDishRequest $request)
    {
        //
        $plato = new Dish();

        if($request->hasFile("image")){

            //obteneos el nombre de la imagen con GetclientOriginalName()
            $nombre = Str::random(10) . '_' . $request->file('image')->getClientOriginalName();

            //Creamos una ruta apuntando al Storage, y a que carpeta irá, tiene que existitr la carpeta
            $ruta = storage_path() . '/app/public/images/platos/' . $nombre;

            //en una sola linea, creamos la imagen, la redimensionamos y la grabamos en la ruta que hemos crado
            Image::make($request->file('image'))->resize(679, 463)->save($ruta);

            //Grabamos en la base de datos toda la ruta de la imagen
            $plato->uri_image = '/storage/images/platos/';
            $plato->name_image = $nombre;

        }

        $plato->name = $request->name;
        $plato->description = $request->description;

        $plato->type = $request->type;

        $plato->save();

        
        /*
        if($at == null){

        }else{
            //convertimos el array de los valores de los atributos
            $attr = explode(",",$at);
            $plato->menus()->sync($attr);    
        }
        */

        return redirect('/admin/dishes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        //
    }
}
