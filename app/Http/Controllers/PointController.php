<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;


class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $puntos = Point::all();
        return $puntos;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        //
    }

    public function getPoints(Request $request)
    {
        //

        try{

            $puntos = DB::table('users')
                    ->join('activities', 'users.id', '=', 'activities.user_id')
                    ->join('points', 'activities.id', '=', 'points.activity_id')
                    ->where('users.id', $request->id)
                    ->get();

            $total = 0;

            foreach ($puntos as $key => $punto) {
                $total = $total + $punto->valor_jim;
            }
            

        }catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        
        return response()->json([
            'status' => 200,
            'msg' => 'Cantidad de puntos',
            'Total' => $total,
        ]);

        /*
        return $this->successResponse([
            'status' => 200,
            'data' => $puntos,
        ]);
        */


      

    }
}
