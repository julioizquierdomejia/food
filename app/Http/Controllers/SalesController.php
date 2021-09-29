<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SalesController extends Controller
{
    public function index()
    {
        $sales = DB::table('user_tickets')
            ->join('users', 'users.id', '=', 'user_tickets.user_id')
            ->join('tickets', 'tickets.id', '=', 'user_tickets.ticket_id')
            ->join('raffles', 'raffles.id', '=', 'tickets.raffle_id')
            ->join('items', 'items.id', '=', 'raffles.item_id')
            ->selectRaw('user_id, users.name as client, concat(items.name, " ", items.description) as product,
             items.price, raffles.id as raffle_id, raffles.status as raffled, raffles.end_date')
            ->distinct()
            ->get();

        foreach ($sales as $sale){
            $user_tickets = DB::table('user_tickets')
                ->join('users', 'users.id', '=', 'user_tickets.user_id')
                ->join('tickets', 'tickets.id', '=', 'user_tickets.ticket_id')
                ->where('user_id', $sale->user_id)
                ->selectRaw('SUM(tickets.price) as precio, SUM(tickets.quantity) as quantity')
                ->first();
            $sale->precio = $user_tickets->precio;
            $sale->quantity = $user_tickets->quantity;
        }

        return view('admin.sales.index', compact('sales'));
    }
}
