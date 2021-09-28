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
            $categories = Category::all();
            $raffles = Raffle::join('items','raffles.item_id', '=' , 'items.item_id')
            ->where('status','=','0')
            ->where('active','=','1')
            ->where('winner_id','!=',null)
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

}
