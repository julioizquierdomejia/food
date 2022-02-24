<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRaffleRequest;

use App\Models\Raffle;
use App\Models\Offer;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Carbon\Carbon;

class RaffleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sorteos = Raffle::where('status', 1)->get();
        
        return view('admin.raffle.index', compact('sorteos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $ofertas = Offer::where('status', 1)->get();;

        return view('admin.raffle.create', compact('ofertas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRaffleRequest $request)
    {
        //

        
        $at = $request->ofertas_array;

        $sorteo = new Raffle();

        if($request->hasFile("image")){

            //obteneos el nombre de la imagen con GetclientOriginalName()
            $nombre = Str::random(10) . '_' . $request->file('image')->getClientOriginalName();

            //Creamos una ruta apuntando al Storage, y a que carpeta irá, tiene que existitr la carpeta
            $ruta = storage_path() . '/app/public/images/sorteos_image/' . $nombre;


            //en una sola linea, creamos la imagen, la redimensionamos y la grabamos en la ruta que hemos crado
            Image::make($request->file('image'))->resize(679, 463)->save($ruta);

            //Grabamos en la base de datos toda la ruta de la imagen
            $sorteo->uri_image = '/storage/images/sorteos_image/';
            $sorteo->name_image = $nombre;

        }

        $sorteo->name = $request->name;
        $sorteo->description = $request->description;

        //manipulamos fechas con CARBON
        $fecha_inicio = Carbon::parse($request->start_date)->format('d-m-y');
        $fecha_final = Carbon::parse($request->end_date)->format('d-m-y');
        $fecha_limite = Carbon::parse($request->income_limit)->format('d-m-y');

        $sorteo->start_date = $fecha_inicio;
        $sorteo->end_date = $fecha_final;
        $sorteo->income_limit = $fecha_limite;

        $sorteo->prize = $request->prize;
        $sorteo->goal = $request->goal;

        $sorteo->save();

        if($at == null){

        }else{
            //convertimos el array de los valores de los atributos
            $attr = explode(",",$at);
            $sorteo->offers()->sync($attr);    
        }

        return redirect('/admin/raffle');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function show(Raffle $raffle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function edit(Raffle $raffle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Raffle $raffle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raffle $raffle)
    {
        //
    }
}
