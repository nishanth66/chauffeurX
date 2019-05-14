<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverPayment
 * @package App\Models
 * @version May 11, 2019, 1:15 am MDT
 *
 * @property string driverid
 * @property string amount
 * @property string cardid
 */
class driverPayment extends Model
{
    use SoftDeletes;

    public $table = 'driver_payments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'driverid',
        'amount',
        'cardid'
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
        'cardid' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
