<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Menu;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$ordenes = Order::all();
        $usuarios = User::all();
        $menus = Menu::all();
        $platos = Dish::all();

        
        $ordenes = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('menus', 'orders.menu_id', '=', 'menus.id')
            ->select('orders.id', 'users.uri_image', 'users.name_image', 'users.name as nombre', 'menus.name as menu', 'orders.uri_image as uri', 'orders.name_image as image', 'orders.turn as turno', 'orders.schedule as horario', 'orders.status as status', 'menus.date as fecha')
            //->select('browser', DB::raw('count(*) as total'))
            //->groupBy('browser')
            ->get();


        return view('admin.orders.index', compact('ordenes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function consumo()
    {
        //
        $usuarios = User::all();
        return view('admin.orders.consumo', compact('usurios'));
    }



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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
