<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use App\Models\UserTicket;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sales = UserTicket::distinct()->with('ticket.raffle.item', 'user')->get();
        $raffles = Raffle::with('winner', 'item')->get();
        return view('admin.sales.index', compact('sales', 'raffles'));
    }
}
