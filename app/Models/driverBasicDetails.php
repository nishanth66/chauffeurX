<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverBasicDetails
 * @package App\Models
 * @version April 15, 2019, 12:30 am MDT
 *
 * @property string driverid
 * @property string address
 * @property string city
 * @property string state
 * @property string country
 */
class driverBasicDetails extends Model
{
    use SoftDeletes;

    public $table = 'driver_basic_details';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'driverid',
        'address',
        'city',
        'state',
        'country'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'driverid' => 'string',
        'address' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
