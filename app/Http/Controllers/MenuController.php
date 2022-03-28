<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Dish;
use App\Models\Parameter;
use Illuminate\Http\Request;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $menus = Menu::all();
        $datos = Parameter::where('status', 1)
                    ->orderBy('created_at', 'asc')
                    ->get()->last();

        return view('admin.menus.index', compact('menus', 'datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    

    
    public function create()
    {
        //
        $platos = Dish::all();

        return view('admin.menus.create', compact('platos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {

        $at = $request->type;

        $menu = new Menu();

        if($request->hasFile("image")){

            //obteneos el nombre de la imagen con GetclientOriginalName()
            $nombre = Str::random(10) . '_' . $request->file('image')->getClientOriginalName();

            //Creamos una ruta apuntando al Storage, y a que carpeta irá, tiene que existitr la carpeta
            $ruta = storage_path() . '/app/public/images/menus/' . $nombre;


            //en una sola linea, creamos la imagen, la redimensionamos y la grabamos en la ruta que hemos crado
            Image::make($request->file('image'))->resize(800, 800)->save($ruta);

            //Grabamos en la base de datos toda la ruta de la imagen
            $menu->uri_image = '/storage/images/menus/';
            $menu->name_image = $nombre;

        }


        $menu->name = $request->name;
        $menu->description = $request->description;

        //manipulamos fechas con CARBON
        $date = Carbon::parse($request->date);

        $menu->date = $date;

        $menu->price = $request->price;
        $menu->cost = $request->cost;
        $menu->cant = $request->cant;

        $menu->save();

        if($at == null){

        }else{
            //convertimos el array de los valores de los atributos
            $attr = explode(",",$at);
            $menu->platos()->sync($attr);    
        }

        return redirect('/admin/menus');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {

        $platos = Dish::all();
        $platos_selected = $menu->platos;

        $ids_array = [];


        $seleccion = DB::table('dish_menu')
                    ->where('menu_id', $menu->id)->get();

        //armamos los platos
        foreach ($seleccion as $key => $value) {
            array_push($ids_array, $value->dish_id);
        }

        //convertimos el array en String
        $values = implode(',', $ids_array);


        return view('admin.menus.edit', compact('menu', 'platos', 'platos_selected', 'ids_array'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        

        $at = $request->type;

        if($request->hasFile("image")){

            //obteneos el nombre de la imagen con GetclientOriginalName()
            $nombre = Str::random(10) . '_' . $request->file('image')->getClientOriginalName();

            //Creamos una ruta apuntando al Storage, y a que carpeta irá, tiene que existitr la carpeta
            $ruta = storage_path() . '/app/public/images/menus/' . $nombre;


            //en una sola linea, creamos la imagen, la redimensionamos y la grabamos en la ruta que hemos crado
            Image::make($request->file('image'))->resize(800, 800)->save($ruta);

            //Grabamos en la base de datos toda la ruta de la imagen
            $menu->uri_image = '/storage/images/menus/';
            $menu->name_image = $nombre;

        }


        $menu->name = $request->name;
        $menu->description = $request->description;

        //manipulamos fechas con CARBON
        //$date = Carbon::parse($request->date)->format('Y-m-d h:mm:ss');

        //$date = Carbon::parse($request->date)->format('d-m-Y h:m:s');
        $date = Carbon::parse($request->date);

        $menu->date = $date;

        $menu->price = $request->price;
        $menu->cost = $request->cost;
        $menu->cant = $request->cant;

        $menu->update();

        if($at == null){

        }else{
            //convertimos el array de los valores de los atributos
            $attr = explode(",",$at);
            $menu->platos()->sync($attr);    
        }

        return redirect('/admin/menus');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $menu = Menu::find($id);
        $nombre = $menu->name;
        $menu->delete();

        return $nombre.' ha sido Eliminado';
        
    }


    public function updateStatus(Request $request){

        $menu = Menu::find($request->id);

        $menu->update([
            'status' => $request->status,
        ]);
    }
}
