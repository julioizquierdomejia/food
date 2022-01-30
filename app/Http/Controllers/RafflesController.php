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
            //->orderBy('end_date', 'DESC')->get();
            ->orderBy('order', 'ASC')->get();

        foreach ($raffles as $key) {
            $tickets = UserTicket::where('raffles_id',$key->id)
                        ->where('status', 'Success')
                        ->sum('quantity');

            //$acc = $key->raffle_goal_amount*$tickets;
            //Para calcular el acumular de cuantos tickets se han vendido por Rifa
            // Sumámos el campo Quantity que es donde viene el precio de las opciones 
            // y lo dividimos entreo el costo del tikect de cada item
            $acc = $tickets/$key->item->price; //$key->raffle_goal_amount/$key->item->price;

            //$porcentaje = ($tickets*100)/$key->raffle_goal_amount;
            $porcentaje = ($acc*100)/$key->raffle_goal_amount;
            $key['accumulate'] = $acc;
            $porcentaje_rounded = round($porcentaje, 2);
            $key['porcentaje'] = $porcentaje_rounded;
            
            //
            // Calculemos el porcentaje con los campos de cantidad  { @julio.izquierdo.mejia }
            // Informacion para el calculo del porcentaje segun la cantidad de ventas de rifas
            //
            // Tabla user_tickets -->> campo {{ quantity }}  ->>> este campo tiene la cantidad de de rifas compradas por un usuario
            // Tabla raffles -->> campo {{ rafle_goal_amount }}  ->>> ete campo tiene la cantidad total de rifas que se tienen que vender
            //
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
        
        //revisamos el ultimo numero de orden
        $rifas_all = Raffle::orderBy('order')
               ->get();

        if($rifas_all->count() == 0){
            //Asignamos 1 al numero de orden
            $last_order = 1;
        }else{
            //genero el ultimo numero de orden de posicion en relacion al mayor de la tabla
            $last_order = $rifas_all->last()->order + 1;    
        }



        $this->validate($request, Raffle::rules());
        $raffles = $request->all();

        //$tickets = $request->tickets;
        $raffles['tickets_number'] = 0; 
        
        //$raffle = Raffle::create($raffles);

        //cramos el objeto de tipo Raffle
        $raffle = new Raffle();

        $raffle->item_id = $request->item_id;
        $raffle->raffle_goal_amount = $request->raffle_goal_amount;
        $raffle->order = $last_order;
        $raffle->start_date = $request->start_date;
        $raffle->end_date = $request->end_date;

        $raffle->save();

        /*
        "_token" => "lERiSDNqKUfC6EKon2ZZZ1of48PeD0V6DcopkiY9"
        "item_id" => "18"
        "raffle_goal_amount" => "1000"
        "start_date" => "2022-01-12"
        "end_date" => "2022-01-12"
        */

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

    public function update_order_raffles(Request $request, Raffle $raffle){

    
        $newOrder = $request->order;
        $rifas = Raffle::all();

        $nuevoOrden = 0;

        /*
        foreach ($rifas as $key_rifa => $rifa) {
            foreach ($newOrder as $key => $orden) { //el numero de Orden es el ID del Item
                $nuevoOrden = $key_rifa + 1;
                if ($orden == $rifa->order) {
                    $rifa->update(['order' => $nuevoOrden]);
                }
                //return $orden;

                //$nuevoOrden = $key + 1;
                //$raffle = Raffle::where('order', $orden)->first();
                //$raffle->update(['order' => $nuevoOrden]);
                //return $key;
            }    
        }
        */

        $array_vacio = [];

        foreach ($newOrder as $key => $order) {
            $raffle = Raffle::find($order);
            $raffle->update(['order' => $key]);
            //$raffle->order = $key;
            //$raffle->save();
            array_push($array_vacio, $order, $key);
        }
        


        //$post = $request->order[2];
        return $array_vacio;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        
        #---------------------------------------------------------@
        #                                                         #     
        #  @julioIzquierdoMejia | modifico este codigo            # 
        #                                                         #
        #---------------------------------------------------------@

        $user_ticket = UserTicket::where('raffles_id',$id)->get();  // esta es una coleccion
        $rafle_winner = RaffleWinner::where('raffle_id',$id)->get(); //este registro es unico | Confirmar si hay un solo ganador por Rifa |
        $rafle_favorite = RaffleFavorite::where('raffle_id',$id)->get();  // esta es una coleccion un user puede tener varias Rifas de favoritas
        

        if($user_ticket->count() > 0){
            //dd($user_ticket); //UserTicket::where('raffles_id',$id)->destroy();
            foreach ($user_ticket as $user_t) {
                $user_ticket_ = UserTicket::find($user_t->id)->delete();
            }
        }

        if($rafle_winner->count() > 0){
            foreach ($rafle_winner as $winner) {
                $winner_ = RaffleWinner::find($winner->id)->delete();
            }
        }

        if($rafle_favorite->count() > 0){
            foreach ($rafle_favorite as $favotirte) {
                $favorite_ = RaffleFavorite::find($favotirte->id)->delete();
            }
        }        

        Raffle::destroy($id);
        
        
        //esta tabla aun no se que hace
        //Ticket::where('raffle_id',$id)->destroy();
        

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
