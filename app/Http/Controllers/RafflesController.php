<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Raffle;
use App\Models\Ticket;
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
            ->orderBy('end_date', 'DESC')->paginate(15);
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
        $tickets = $request->tickets;
        $raffles['tickets_number'] = array_sum(array_column($tickets, 'quantity'));
        $raffle = Raffle::create($raffles);

        foreach ($tickets as $ticket) {
            Ticket::create([
                'raffle_id' => $raffle->id,
                'quantity' => $ticket['quantity'],
                'price' => $ticket['price'],
            ]);
        }

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
        $tickets = Ticket::where('raffle_id', $raffle->id)->get();
        return view('admin.raffles.edit', compact('raffle', 'items', 'tickets'));
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
        $data['tickets_number'] = array_sum(array_column($tickets, 'quantity'));

        Ticket::where('raffle_id', $raffle->id)->delete();
        foreach ($tickets as $ticket) {
            Ticket::create([
                'raffle_id' => $raffle->id,
                'quantity' => $ticket['quantity'],
                'price' => $ticket['price'],
            ]);
        }

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
        return back()->withSuccess(trans('app.success_destroy'));
    }
}
