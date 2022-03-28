<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos = Parameter::where('status', 1)
                    ->orderBy('created_at', 'asc')
                    ->get()->last();
        return view('admin.config.index', compact('datos'));

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $dia_hoy = Carbon::now()->day;

        $mensaje = "";
        if ($request->cantidad >= $dia_hoy) {
            $mensaje = "Ahora pueden tener " . $request->cantidad . " Gratis";

            $parametros = new Parameter();
            $parametros->cancelTime = $request->cancelacion;
            $parametros->freeCant = $request->cantidad;

            $parametros->save();    

        }else{
            $mensaje = "Estamos día " . $dia_hoy . " No puedes reducir la cantidad de Menus Gratis hasta el proximo mes";
        }

        return $mensaje;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter, $id)
    {
        //
        $parametros = Parameter::where('id', $id)->first();

        $parametros->freeCant = $request->freeCant;
        $parametros->cancelTime = $request->cancelTime;

        $parametros->update();

        return redirect('/admin/config');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        //
    }
}
