<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class passenger_rating
 * @package App\Models
 * @version March 23, 2019, 7:41 am UTC
 *
 * @property string bookingid
 * @property string userid
 * @property string driverid
 * @property string rating
 * @property string comments
 */
class passenger_rating extends Model
{
    use SoftDeletes;

    public $table = 'passenger_ratings';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'bookingid',
        'userid',
        'driverid',
        'rating',
        'comments'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bookingid' => 'string',
        'userid' => 'string',
        'driverid' => 'string',
        'rating' => 'string',
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
