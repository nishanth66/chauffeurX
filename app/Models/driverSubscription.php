<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverSubscription
 * @package App\Models
 * @version May 29, 2019, 10:19 pm MDT
 *
 * @property string city
 * @property string category
 * @property string amount
 */
class driverSubscription extends Model
{
    use SoftDeletes;

    public $table = 'driver_subscriptions';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'city',
        'category',
        'amount',
        'stripe_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'city' => 'string',
        'category' => 'string',
        'amount' => 'string',
        'stripe_id' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
