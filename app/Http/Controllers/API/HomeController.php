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
use App\Models\Offer;
use App\Models\Ticket;
use App\Models\Item;
use App\Models\RaffleFavorite;
use App\Models\UserTicket;

use App\Models\Country;

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

    
    public function getCountries()
    {
        try {
            $countries = Country::where('status',1)->get();


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'countries' => $countries,
        ]);
    }

    public function getRaffles(Request $request)
    {
        try {

            $id_user = $request->user_id;

            $slider = Slider::where('status',1)->get();
            $sorteos = Raffle::where('status',1)->get();

            $favoritos = Favorite::all();

            //recorremos para recoger las ofertas de cada rifa
            foreach ($sorteos as $key => $sorteo) {

                foreach($favoritos as $key => $favorito){
                    $id_table = $favorito->user_id . $favorito->raffle_id;
                    $id_current = $id_user . $sorteo->id;
                    if ($id_table == $id_current) {
                        $sorteo['favorito'] = 'true';
                    }else{
                        $sorteo['favorito'] = 'false';
                    }
                
                }

                $sorteo->offers;
                $sorteo = json_encode($sorteo);

            }


        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'slider' => $slider,
            'sorteos' => $sorteos,
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
