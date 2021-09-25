<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RaffleWinner;
use Illuminate\Http\Request;

class RaffleWinnersController extends Controller
{
    public function index()
    {
        $winners = RaffleWinner::all();
        return view('admin.raffle_winners.index', compact('winners'));
    }
}
