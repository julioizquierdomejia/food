<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Carousel;
use App\Models\Category;
use App\Models\Raffle;
use App\Models\Slider;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Item;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\Parameter;

use App\Models\Country;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;




class HomeController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/home",
     *     summary="Retorna los datos a mostrar en el inicio",
     *     tags={"Home"},
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function index()
    {

        try {
            $carousel = Carousel::all();
            $categories = Category::select('id','name','icon')->get();

            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
                ->where('raffles.status','=','0')
                ->where('raffles.active','=','0')
                ->where('winner_id','=',null)
                ->orderBy('order','asc')
                ->select('raffles.id','raffles.item_id','start_date','end_date','raffle_goal_amount','progress','category_id','name','description','image','price')
                ->get();

            foreach ($raffles as $key) {
                $tickets = UserTicket::where('raffles_id',$key->id)
                            ->where('status', 'Success')
                            ->sum('quantity');
                

                $acc = $tickets/$key->item->price; //$key->raffle_goal_amount/$key->item->price;

                //$porcentaje = ($tickets*100)/$key->raffle_goal_amount;
                $porcentaje = ($acc*100)/$key->raffle_goal_amount;
                $key['accumulate'] = $acc;
                $porcentaje_rounded = round($porcentaje, 10);
                $porcen = (String)$porcentaje;
                $key['porcentaje'] = $porcen;

                //$acc = $key->raffle_goal_amount; // cantidad de tikects comprados
                
                /*
                $porcentaje = (($tickets*100)/$key->raffle_goal_amount);
                $porcentaje = round($porcentaje,2);
                $key['accumulate'] = $acc;
                $key['porcentaje'] = $porcentaje;
                */


                //$porcentaje = ($acc*100)/$key->raffle_goal_amount;
                //$porcentaje = $acc/$key->raffle_goal_amount;
                //$cant_tikets = (int)$tickets;
                //$porcentaje = $acc / $cant_tikets;
                //$key['accumulate'] = $acc;
                //$porcentaje_rounded = round($porcentaje, 2);
                //$key['porcentaje'] = $porcentaje; //$porcentaje_rounded;

            }

            for ($i = 0; $i < count($raffles); $i++ ) {

                //$favorite = RaffleFavorite::where('raffle_id',$raffles[$i]['raffle_id'])
                $favorite = RaffleFavorite::where('raffle_id',$raffles[$i]->id)
                ->where('user_id',auth()->guard('api')->user()->id)
                ->get()->first();

                $favorite != null ? $raffles[$i]['favorite'] = true : $raffles[$i]['favorite'] = false;
            }

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => [
                'carousel' => $carousel,
                'categories' => $categories,
                'raffles' => $raffles
            ],
        ]);
        
    }
    /**
     * @OA\Get(
     *     path="/category/{id_category}",
     *     summary="Retorna las rifas por categoria",
     *     tags={"Category"},
     *     @OA\Parameter(
     *          name="id_category",
     *          description="id de categoria",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Page category data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function items_category($id_category)
    {
        try {
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
            ->where('raffles.status','=','0')
            ->where('raffles.active','=','0')
            ->where('winner_id','=',null)
            ->where('category_id','=',$id_category)
            ->select('raffles.id','raffles.item_id','start_date','end_date','raffle_goal_amount','progress','category_id','name','description','image','price')
            ->get();

            for ($i = 0; $i < count($raffles); $i++ ) {
                $favorite = RaffleFavorite::where('raffle_id',$raffles[$i]['raffle_id'])
                ->where('user_id',auth()->guard('api')->user()->id)
                ->get()->first();

                $favorite != null ? $raffles[$i]['favorite'] = true : $raffles[$i]['favorite'] = false;
            }

            foreach ($raffles as $key) {
                $tickets = UserTicket::where('raffles_id',$key->id)
                            ->where('status', 'Success')
                            ->sum('quantity');
                            
                
                $acc = $key->raffle_goal_amount*$tickets;
                $porcentaje = ($tickets*100)/$key->raffle_goal_amount;
                $porcentaje = round($porcentaje,10);
                $key['accumulate'] = $acc;
                $porcen = (String)$porcentaje;
                $key['porcentaje'] = $porcen;
            }

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'raffles' => $raffles
            ,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/winners",
     *     summary="Retorna los datos a mostrar en el inicio",
     *     tags={"Home"},
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */

    
    public function updateStatus(Request $request)
    {
        try {
            

            $id = $request->id;
            $array_ids = explode(',', $id);

            //buscamos si existe el registro
            $orden = Order::where('user_id', $array_ids[0])
                        ->where('menu_id', $array_ids[1])
                        ->first();
            
            if($orden->status == 1){
                $orden->status = 2;
                $orden->update();
            }else{
                return $this->errorResponse('Este Pedido ya fue solicitado', 400);
            }


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'Orden' => $orden,
            'msg' => 'Ahora el Pedido esta listo para ser recogido',
        ]);
    }

    public function cancelOrder(Request $request)
    {
        try {

            
            $id = $request;

            $array_ids = explode(',', $id);


            //buscamos si existe el registro
            /*
            $orden = Order::where('user_id', $array_ids[0])
                        ->where('menu_id', $array_ids[1])
                        ->first();
                    */

            $orden = Order::where('user_id', $request->user_id)
                        ->where('menu_id', $request->menu_id)
                        ->first();
            
            if($orden->status == 1){
                $orden->status = 3;
                $orden->update();
                $msg = 'El pedido fue cancelado';
            }else{
                if($orden->status == 2){
                    return $this->errorResponse('Este Pedido ya fue Atendido', 400);
                }else{
                    if($orden->status == 3){
                        return $this->errorResponse('Este Pedido ya esta cancelado', 400);  
                    }else{
                        if($orden->status == 4){
                            return $this->errorResponse('Este Pedido ya no se consumio', 400);  
                        }
                    }
                }
                
            }


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'Orden' => $orden,
            'msg' => $msg,
        ]);
    }


    public function getMenus(Request $request)
    {
        try {

            $menus = Menu::where('status', 1)->get();
            $orders = Order::all();
            $parametros = Parameter::all()->last();
            
            foreach ($menus as $menu) {

                $menu['pedido'] = $menu->pedidos->count();
                $menu['tiempoCancel'] = $parametros->cancelTime;

                $menu->platos;
                $menu = json_encode($menu);

            }


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'menus' => $menus,
        ]);
    }

    public function getHistory(Request $request)
    {
        try {

            $orders = Order::where('user_id', $request->id)
                        //->join('dishes', 'orders.entrada_id', '=', 'dishes.id')
                        ->get();

            $menus = Menu::where('status', 1)->get();
            $platos = Dish::all();


            
            $parametros = Parameter::all()->last();
            
            foreach ($orders as $order) {
                $order['tiempoCancel'] = $parametros->cancelTime;
                //vemos el nombre del Menu
                foreach ($menus as $key => $menu) {
                    if ($menu->id == $order->menu_id) {
                        $order['Menu'] = $menu->name;
                        $order['imagen'] = $menu->uri_image.$menu->name_image;
                    }
                }

                //vemos el nombre dela Entrada
                foreach ($platos as $key => $plato) {
                    if ($plato->id == $order->entrada_id) {
                        $order['Entrada'] = $plato->name;
                    }
                }

                //vemos el nombre del plato de fondo
                foreach ($platos as $key => $plato) {
                    if ($plato->id == $order->segundo_id) {
                        $order['Plato de Fondo'] = $plato->name;
                    }
                }

                //vemos el nombre del plato de Postre
                foreach ($platos as $key => $plato) {
                    if ($plato->id == $order->postre_id) {
                        $order['Postre'] = $plato->name;
                    }
                }

            }


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'menus' => $orders,
        ]);
    }



    public function registerOrder(Request $request)
    {
        try {

            
            $validator = Validator::make($request->all(), [
                'menu_id' => 'required',

            ], [
                'menu_id.required' => 'Elegir al menos una opci??n del Men??',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 400);
            }

            $orden = new Order();

            //creamos un id unico de la mezcla de user_id y menu_id
            $id = $request->user_id . ',' . $request->menu_id;
            $nombre = $id . '.png';

            $ruta = storage_path() . '/app/public/images/qr/' . $nombre;

            //generamos el Codigo QR
            QrCode::format('png')->size(700)->generate($id, $ruta);

            //Grabamos en la base de datos toda la ruta de la imagen
            $orden->uri_image = '/storage/images/qr/';
            $orden->name_image = $nombre;

            $orden->user_id = $request->user_id;
            $orden->menu_id = $request->menu_id;

            $orden->entrada_id = $request->entrada_id;
            $orden->segundo_id = $request->segundo_id;
            $orden->postre_id = $request->postre_id;

            $orden->turn = $request->turn;
            $orden->schedule = $request->schedule;

            $orden->save();
            

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'order' => $orden,
            'msg' => 'La orden fue registrada',
            
        ]);
    }

    
    public function getOffer()
    {
        try {
            $ofertas = Offer::where('status',1)->get();


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'ofertas' => $sorteo,

        ]);
    }

    /*
    public function winners()
    {
        try {
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
            ->join('raffle_winners','raffle_winners.raffle_id','=','raffles.id')
            ->join('users','raffles.winner_id','=','users.id')
            ->where('winner_id','!=',null)
            //->where('raffle_winners.banner','!=','default')
            ->get();

            foreach ($raffles as $key) {
                //return $key['item_id']; 
                $nombre_producto = Item::find($key['item_id']);
                $key['name'] = $nombre_producto->name;

                $nombre_user = User::find($key['winner_id']);
                $key['name_winner'] = $nombre_user->name;
                

            };



        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'raffles' => $raffles,
        ]);
    }
    */

    /**
     * @OA\Get(
     *     path="/detailRaffle/{id_raffle}",
     *     summary="Retorna el detalle de una rifa.",
     *     tags={"Home"},
     *     @OA\Parameter(
     *          name="id_raffle",
     *          description="id de rifa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function detail($id_raffle)
    {

        try {
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
            ->join('categories','items.category_id', '=', 'categories.id')
            ->select('raffles.id','raffles.item_id','start_date','end_date','raffle_goal_amount','progress','category_id','items.name','description','items.image','price','categories.name AS namecategory')->where('raffles.id', $id_raffle)
            ->get()->first();

            $tickets = UserTicket::where('raffles_id',$raffles->id)
                        ->where('status', 'Success')
                        ->sum('quantity');

            $acc = $raffles->raffle_goal_amount; //
            $raffles['accumulate'] = $acc;
            $porcent = ($tickets * 100) / $acc ;
            $porcent_round = round($porcent, 10);
            $porcent_string = (String)$porcent_round;
            $raffles['porcentaje'] = $porcent_string;

            //$acc = $raffles->raffle_goal_amount*$tickets;
            //$acc = $raffles->raffle_goal_amount/$tickets;
            //$raffles['accumulate'] = $acc;
            //$porcentaje = ($tickets*100)/$raffles->raffle_goal_amount;
            //$porcentaje_rounded = round($porcentaje, 2);
            //$raffles['porcentaje'] = $porcentaje_rounded;

            /*
            $porcentaje = ($acc*100)/$raffles->raffle_goal_amount;
            $raffles['accumulate'] = $acc;
            $porcentaje_rounded = round($porcentaje, 2);
            $divido = $porcentaje_rounded/100;
            $redondeado = round($divido, 2);
            $raffles['porcentaje'] = $redondeado;
            */


            $favorite = RaffleFavorite::where('raffle_id',$id_raffle)
            ->where('user_id',auth()->guard('api')->user()->id)
            ->get()->first();

            $favorite != null ? $raffles['favorite'] = true : $raffles['favorite'] = false;


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'raffle' => $raffles,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/favoritesRaffles",
     *     summary="Retorna tus rifas favoritas.",
     *     tags={"Home"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function favorites()
    {
        try {
            $raffles = Raffle::join('raffle_favorites','raffles.id','=','raffle_favorites.raffle_id')
            ->join('items','raffles.item_id', '=' , 'items.id')
            ->where('raffle_favorites.user_id',auth()->guard('api')->user()->id)
            ->select('raffles.id','raffles.item_id','start_date','end_date','raffle_goal_amount','progress','category_id','name','description','image','price')
            ->get();

            foreach ($raffles as $key) {
                $tickets = UserTicket::where('raffles_id',$key->id)
                            ->where('status', 'Success')
                            ->sum('quantity');
                            
                
                $acc = $key->raffle_goal_amount*$tickets;
                $porcentaje = ($tickets*100)/$key->raffle_goal_amount;
                $porcentaje = round($porcentaje,10);
                $key['accumulate'] = $acc;
                $porcen = (String)$porcentaje;
                $key['porcentaje'] = $porcen;
            }




        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'raffles' => $raffles,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/users/favorites",
     *     summary="New favorite",
     *     tags={"Usuarios"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="id_raffle",
     *                     type="integer"
     *                 ),
     *                 example={"id_raffle": "123456"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *     security={{"apiAuth": {} }},
     *     deprecated=false
     * )
     */
    public function NewFavorite(Request $request)
    {
        try {

            $favorites = RaffleFavorite::where('raffle_id', $request->get('id_raffle'))
            ->where('user_id', auth()->guard('api')->user()->id)
            ->get()->first();

            if (!is_null($favorites)) {
                $favorites->delete();
                return $this->successResponse([
                    'status' => 200,
                    'message' => 'Favorite deleted'
                ]);
            }

            $newFavorite = new RaffleFavorite();
            $newFavorite->user_id = auth()->guard('api')->user()->id;
            $newFavorite->raffle_id = $request->get('id_raffle');
            $newFavorite->save();

            return $this->successResponse([
                'status' => 200,
                'message' => 'Favorite register',
                'data' => $newFavorite
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/users/favorites/{id_raffle}",
     *     summary="Delete favorite",
     *     tags={"Usuarios"},
     *
     *     @OA\Parameter(
     *          name="id_raffle",
     *          description="id de rifa",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="400",
     *         description="Failed",
     *     ),
     *     security={{"apiAuth": {} }},
     *     deprecated=false
     * )
     */
    public function DeleteFavorite($id_raffle)
    {
        try {

            $favorites = RaffleFavorite::where('raffle_id', $id_raffle)
            ->where('user_id', auth()->guard('api')->user()->id)
            ->get()->first();

            if (is_null($favorites)) {
                return $this->errorResponse('No se encontro favorito', 400);
            }

           $favorites->delete();

            return $this->successResponse([
                'status' => 200,
                'message' => 'Favorite deleted'
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/myshopping",
     *     summary="Retorna tus rifas favoritas.",
     *     tags={"Home"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Home page data"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     ),
     *
     *
     *     security={{"apiAuth": {} }},
     *
     *     deprecated=false
     *
     * )
     */
    public function shopping()
    {

        try {
                        
            $raffles = UserTicket::join('raffles','raffles.id','=','user_tickets.raffles_id')
                ->join('items', 'raffles.item_id', '=', 'items.id')
                ->where('user_tickets.user_id',auth()->guard('api')->user()->id)
                ->where('user_tickets.status','Success')
                //->where('user_tickets.status','INITIALIZED')
                ->select('raffles.id','user_tickets.id as ticket','start_date','end_date','raffle_goal_amount','user_tickets.quantity', 'items.name', 'items.description', 'items.price')
                ->get();

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles,
        ]);
    }


    public function shoppingStatusSuccess(Request $request)
    {

        $idOrder = $request->order_id;


        try{
            
            $raffles = UserTicket::where('user_tickets.user_id',auth()->guard('api')->user()->id)
                        ->where('oreder_id',$idOrder)
                        ->get();

            foreach ($raffles as $key) {
                $key->status = 'Success';
                $key->update();
            }
            
            

        }catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles,
        ]);



        
    }

    
}
