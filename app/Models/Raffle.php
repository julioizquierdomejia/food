<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Raffle extends Model
{
    use HasFactory;

    protected $table = 'raffles';
    protected $fillable = [
        'item_id',
        'winner_id',
        'start_date',
        'end_date',
        'max_tickets_number',
        'raffle_goal_amount',
        'tickets_number',
        'progress',
        'active',
        'status',
        'order',
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null)
    {
        return [
            'item_id' => 'required',
        ];
    }

    /*
    |------------------------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------------------------
    */

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

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

    protected $dates = [
        'start_date',
        'end_date',
    ];
}
