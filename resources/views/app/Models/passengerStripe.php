<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class passengerStripe
 * @package App\Models
 * @version February 27, 2019, 11:55 am UTC
 *
 * @property int userid
 * @property string cardNo
 * @property string fingerprint
 * @property string token
 * @property string brand
 * @property string customerId
 * @property string digits
 */
class passengerStripe extends Model
{
    use SoftDeletes;

    public $table = 'passenger_stripes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'userid',
        'cardNo',
        'fingerprint',
        'token',
        'brand',
        'customerId',
        'digits',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cardNo' => 'string',
        'fingerprint' => 'string',
        'token' => 'string',
        'brand' => 'string',
        'customerId' => 'string',
        'digits' => 'string',
        'status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
