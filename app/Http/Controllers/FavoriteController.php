<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

use App\Models\Raffle;
use App\Models\User;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try{

            $favorito = new Favorite();
            $favorito->user_id = $request->user_id;
            $favorito->raffle_id = $request->raffle_id;

            $favorito->save();
            

        }catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        
        return response()->json([
            'status' => 200,
            'msg' => 'Favorito Agregado',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        //$user_id = (int)$request->user_id;
        $favorito = Favorite::where('user_id',$request->user_id)
                            ->where('raffle_id',$request->raffle_id)
                            ->first();
                            
        $favorito->delete();
                            
        return response()->json([
            'status' => 200,
            'msg' => 'Favorito Eliminado',
        ]);

        

    }
}
