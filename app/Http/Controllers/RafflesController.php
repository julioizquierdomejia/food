<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Raffle;
use App\Models\RaffleFavorite;
use App\Models\RaffleWinner;
use App\Models\Ticket;
use App\Models\UserTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RafflesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $raffles = Raffle::with('item')->where('status', 0)
            ->where('winner_id',null)
            ->orderBy('end_date', 'DESC')->get();

        foreach ($raffles as $key) {
            $tickets = UserTicket::where('raffles_id',$key->id)->sum('quantity');
            $acc = $key->raffle_goal_amount*$tickets;
            $key['accumulate'] = $acc;
        }

        $items = Item::orderBy('id', 'DESC')->get();
        return view('admin.raffles.index', compact('raffles', 'items'));
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
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, Raffle::rules());
        $raffles = $request->all();
        //$tickets = $request->tickets;
        $raffles['tickets_number'] = 0;
        $raffle = Raffle::create($raffles);

        /* foreach ($tickets as $ticket) {
            Ticket::create([
                'raffle_id' => $raffle->id,
                'quantity' => $ticket['quantity'],
                'price' => $ticket['price'],
            ]);
        } */

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $raffle = Raffle::find($id);
        $items = Item::orderBy('id', 'DESC')->get();
        /* $tickets = Ticket::where('raffle_id', $raffle->id)->get(); */
        return view('admin.raffles.edit', compact('raffle', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->validate($request, Raffle::rules(true, $id));

        $raffle = Raffle::findOrFail($id);
        $data = $request->all();
        $tickets = $request->tickets;
        $data['tickets_number'] = 0;

        /* Ticket::where('raffle_id', $raffle->id)->delete();
        foreach ($tickets as $ticket) {
            Ticket::create([
                'raffle_id' => $raffle->id,
                'quantity' => $ticket['quantity'],
                'price' => $ticket['price'],
            ]);
        } */

        $raffle->update($data);

        return redirect()->route(ADMIN . '.raffles.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        Raffle::destroy($id);
        UserTicket::where('raffles_id',$id)->destroy();
        RaffleWinner::where('raffle_id',$id)->destroy();
        RaffleFavorite::where('raffle_id',$id)->destroy();
        Ticket::where('raffle_id',$id)->destroy();
        return back()->withSuccess(trans('app.success_destroy'));
    }
}
