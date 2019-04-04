<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverTips
 * @package App\Models
 * @version February 26, 2019, 11:51 am UTC
 *
 * @property string booking_id
 * @property string userid
 * @property string driverid
 * @property string amount
 * @property string comments
 */
class driverTips extends Model
{
    use SoftDeletes;

    public $table = 'driver_tips';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'booking_id',
        'userid',
        'driverid',
        'amount',
        'comments'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'booking_id' => 'string',
        'userid' => 'string',
        'driverid' => 'string',
        'amount' => 'string',
        'comments' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
