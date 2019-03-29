<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class rating
 * @package App\Models
 * @version February 26, 2019, 11:02 am UTC
 *
 * @property string userid
 * @property string booking_id
 * @property string driverid
 * @property string rating
 * @property string comments
 */
class rating extends Model
{
    use SoftDeletes;

    public $table = 'ratings';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'userid',
        'booking_id',
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
        'userid' => 'string',
        'booking_id' => 'string',
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
