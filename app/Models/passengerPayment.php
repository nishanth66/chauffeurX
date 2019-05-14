<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class passengerPayment
 * @package App\Models
 * @version May 11, 2019, 1:11 am MDT
 *
 * @property string userid
 * @property string bookingid
 * @property string amount
 * @property string cardid
 */
class passengerPayment extends Model
{
    use SoftDeletes;

    public $table = 'passenger_payments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'userid',
        'bookingid',
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
        'userid' => 'string',
        'bookingid' => 'string',
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
