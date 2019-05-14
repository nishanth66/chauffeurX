<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverStripe
 * @package App\Models
 * @version May 11, 2019, 12:49 am MDT
 *
 * @property string userid
 * @property string cardNo
 * @property string fingerprint
 * @property string status
 * @property string token
 * @property string brand
 * @property string customerId
 * @property string digits
 */
class driverStripe extends Model
{
    use SoftDeletes;

    public $table = 'driver_stripes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'driverid',
        'cardNo',
        'fingerprint',
        'status',
        'token',
        'brand',
        'customerId',
        'digits'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'driverid' => 'string',
        'cardNo' => 'string',
        'fingerprint' => 'string',
        'status' => 'string',
        'token' => 'string',
        'brand' => 'string',
        'customerId' => 'string',
        'digits' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
