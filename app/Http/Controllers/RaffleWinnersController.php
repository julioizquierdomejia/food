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

        $winners = RaffleWinner::with('user', 'raffle')->get();
        return view('admin.raffle_winners.index', compact('winners'));
    }

    public function uploadPhoto(Request $request)
    {
        $id = $request->id;
        $raffle = RaffleWinner::find($id);
        if ($request->has('photo')) {
            $files = $request->file('photo');
            $name = "users_" . time() . "." . $files->guessExtension();
            $ruta = public_path("images/users/" . $name);
            copy($files, $ruta);
            $raffle->banner = "images/users/" . $name;
            $raffle->save();
            return back()->withSuccess(trans('app.success_update'));
        }
        return back()->withSuccess('Error al guardar la imagen');
    }

    public function raffleDraw($id)
    {
        $raffles = Raffle::where('status', '0')->get();
        $winners = [];

        foreach ($raffles as $raffle) {
            $tickets = Ticket::where('raffle_id', $raffle->id)->get();
            $box = [];
            foreach ($tickets as $ticket) {
                $user_tickets = UserTicket::where('ticket_id', $ticket->id)->get();
                if ($user_tickets) {
                    foreach ($user_tickets as $user_ticket) {
                        for ($i = 0; $i < $ticket->quantity; $i++) {
                            array_push($box, $user_ticket->user_id);
                        }
                    }
                }
            }

            if (count($box) > 0) {
                shuffle($box);
                shuffle($box);
                $winner_position = array_rand($box);
                $winner_id = $box[$winner_position];

                $raffle_result = Raffle::where('id', $raffle->id)->first();
                $raffle_result->winner_id = $winner_id;
                $raffle_result->status = 1;
                $raffle_result->update();

                $raffle = RaffleWinner::create([
                    'user_id' => $winner_id,
                    'raffle_id' => $raffle->id,
                    'banner' => 'default',
                    'win_date' => getFecha(),
                ]);

                $winner = [
                    "raffle" => $raffle,
                    "winner_id" => $winner_id
                ];

                array_push($winners, $winner);
            }
        }
        $winners = RaffleWinner::with('user', 'raffle')->get();
        return view('admin.raffle_winners.index', compact('winners'));
    }
}
