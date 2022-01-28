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
            //->where('status', 'Success')
            ->join('users', 'users.id', '=', 'user_tickets.user_id')
            ->join('raffles', 'raffles.id', '=', 'user_tickets.raffles_id')
            ->join('items', 'items.id', '=', 'raffles.item_id')
            //->selectRaw('user_id, users.name as client, concat(items.name, " ", items.description) as product, raffles.raffle_goal_amount,user_tickets.quantity, raffles.id as raffle_id, raffles.status as raffled, user_tickets.created_at')
            ->selectRaw('user_id, users.name as client, concat(items.name, " ", items.description) as product, raffles.raffle_goal_amount,user_tickets.quantity, raffles.id as raffle_id, raffles.status as raffled, user_tickets.created_at, items.price, user_tickets.oreder_id, user_tickets.status')
            ->distinct()
            ->get();

        return view('admin.sales.index', compact('sales'));
    }
}
