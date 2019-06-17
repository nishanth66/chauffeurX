<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverPaymentHistory
 * @package App\Models
 * @version May 29, 2019, 10:53 pm MDT
 *
 * @property string driverid
 * @property string amount
 */
class driverPaymentHistory extends Model
{
    use SoftDeletes;

    public $table = 'driver_payment_histories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'driverid',
        'amount',
        'stripe_sub',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'driverid' => 'string',
        'amount' => 'string',
        'stripe_sub' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'driverid' => 'number'
    ];

    
}
