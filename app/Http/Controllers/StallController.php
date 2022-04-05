<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use Illuminate\Http\Request;

class StallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cargos = Stall::all();
        return view('admin.stalls.index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.stalls.create');
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
        $request->validate([
            'name' => 'required',
        ]);

        $cargo = new Stall();
        $cargo->name = $request->name;
        $cargo->save();

        return redirect('/admin/stalls');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function show(Stall $stall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function edit(Stall $stall)
    {
        //
        return view('admin.stalls.edit', compact('stall'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stall $stall)
    {
        //
        $stall->name = $request->name;
        $stall->update();

        return redirect('/admin/stalls');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stall  $stall
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cargo = Stall::find($id);
        $nombre = $cargo->name;
        $cargo->delete();

        return $nombre.' ha sido Eliminado';
        
    }


    public function updateStatus(Request $request){

        $cargo = Stall::find($request->id);

        $cargo->update([
            'status' => $request->status,
        ]);
    }
}
