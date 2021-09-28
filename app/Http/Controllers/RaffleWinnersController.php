<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use App\Models\RaffleWinner;
use App\Models\Ticket;
use App\Models\UserTicket;
use Illuminate\Http\Request;

class RaffleWinnersController extends Controller
{
    public function index()
    {
//        $this->raffleDraw();
        $winners = RaffleWinner::all();
        return view('admin.raffle_winners.index', compact('winners'));
    }

    public function raffleDraw(): bool
    {
        $raffles = Raffle::where('status', '0')->get();
        $winners = [];

        foreach ($raffles as $raffle) {
            $tickets = Ticket::where('raffle_id', 9)->get();
            $box = [];
            foreach ($tickets as $ticket) {
                $user_tickets = UserTicket::where('raffled', '0')->where('ticket_id', $ticket->id)->get();
                if ($user_tickets) {
                    foreach ($user_tickets as $user_ticket) {
                        for ($i = 0; $i < $ticket->quantity; $i++) {
                            array_push($box, $user_ticket->user_id);
                            $u_ticket = UserTicket::where('id', $user_ticket->id)->first();
                            $u_ticket->raffled = 1;
                            $u_ticket->update();
                        }
                    }
                }
//                dd($box, $raffle->id);
                if (count($box) > 0) {
                    shuffle($box);
                    shuffle($box);
                    $winner_position = array_rand($box);
                    $winner_id = $box[$winner_position];

//                    dd($winner_id, $ticket);
                    $raffle_result = Raffle::where('id', $raffle->id)->first();
                    $raffle_result->winner_id = $winner_id;
                    $raffle_result->status = 1;
                    $raffle_result->update();

                    $raffle = RaffleWinner::create([
                        'user_id' => $winner_id,
                        'raffle_id' => $raffle->id,
                        'win_date' => getFecha(),
                    ]);

                    $winner = [
                        "raffle" => $raffle,
                        "winner_id" => $winner_id
                    ];

                    array_push($winners, $winner);
                }
            }
        }
        return true;
    }
}
