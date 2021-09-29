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
            ->select('raffles.id','raffles.item_id','start_date','end_date','raffle_goal_amount','progress','category_id','name','description','image','price')
            ->get();
            

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
            

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles
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
    public function winners()
    {
        try {
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.id')
            ->where('winner_id','!=',null)
            ->join('raffle_winners','raffle_winners.raffle_id','=','raffles.id')
            ->join('users','raffles.winner_id','=','users.id')
            ->get();
            

        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'status' => 200,
            'data' => $raffles,
        ]);
    }
}
