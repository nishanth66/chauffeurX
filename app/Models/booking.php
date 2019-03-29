<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class booking
 * @package App\Models
 * @version February 26, 2019, 10:15 am UTC
 *
 * @property string userid
 * @property string phone
 * @property string completed
 * @property string source
 * @property string destination
 * @property string price
 * @property string distance
 * @property string trip_date
 * @property string trip_time
 * @property string source_description
 * @property string destination_description
 * @property string alternate_phone
 * @property string statu
 * @property string image
 * @property string payment
 * @property string paid
 */
class booking extends Model
{
    use SoftDeletes;

    public $table = 'bookings';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'userid',
        'phone',
        'completed',
        'source',
        'destination',
        'price',
        'distance',
        'trip_date_time',
        'source_description',
        'destination_description',
        'alternate_phone',
        'status',
        'image',
        'payment',
	    'penalty',
        'paid',
        'driverid',
        'estimated_time',
        'categoryId',
        'wait_time',
        'cancelled_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'userid' => 'string',
        'phone' => 'string',
        'completed' => 'string',
        'source' => 'string',
        'destination' => 'string',
        'price' => 'string',
        'distance' => 'string',
        'trip_date_time' => 'string',
        'source_description' => 'string',
        'destination_description' => 'string',
        'alternate_phone' => 'string',
        'status' => 'string',
        'image' => 'string',
        'payment' => 'string',
        'penalty' => 'string',
        'paid' => 'string',
        'estimated_time' => 'string',
        'categoryId' => 'string',
        'wait_time' => 'string',
        'cancelled_at' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
