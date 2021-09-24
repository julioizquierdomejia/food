<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarouselModel extends Model
{
    use HasFactory;

    protected $table = 'ml_carrousel';

    protected $primaryKey = 'idcarrousel';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nameimg',
        'order'
    ];
    protected $casts = [
        'nameimg' => 'string'
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id=null)
    {
        return [
            'nameimg' => 'required|image|mimes:jpeg,png,jpg,bmp|max:5120',
        ];
    }

    /*
    |------------------------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------------------------
    */

    /*
    |------------------------------------------------------------------------------------
    | Scopes
    |------------------------------------------------------------------------------------
    */

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
}
