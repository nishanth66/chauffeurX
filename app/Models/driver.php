<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driver
 * @package App\Models
 * @version February 26, 2019, 10:41 am UTC
 *
 * @property string fname
 * @property string lname
 * @property string image
 * @property string phone
 * @property string car_no
 * @property string licence
 * @property string isAvailable
 * @property string status
 * @property string email
 */
class driver extends Model
{
    use SoftDeletes;

    public $table = 'drivers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'fname',
        'lname',
        'image',
        'phone',
        'car_no',
        'licence',
        'isAvailable',
        'status',
        'email',
        'device_token',
        'referal_code',
        'penalty',
        'device_type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'fname' => 'string',
        'lname' => 'string',
        'image' => 'string',
        'phone' => 'string',
        'car_no' => 'string',
        'licence' => 'string',
        'isAvailable' => 'string',
        'status' => 'string',
        'device_token' => 'string',
        'email' => 'string',
        'referal_code' => 'string',
        'device_type' => 'string',
        'penalty' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
