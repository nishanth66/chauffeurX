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
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'password',
        'code',
        'phone',
        'revenue',
        'licence',
        'isAvailable',
        'status',
        'email',
        'device_token',
        'referal_code',
        'penalty',
        'device_type',
        'city',
        'state',
        'country',
        'apartment',
        'image',
        'licence_expire',
        'discount',
        'ssn',
        'car_inspection',
        'car_reg',
        'car_insurance',
        'driving_licence',
        'activated',
        'basic_details',
        'address_details',
        'licence_details',
        'documents',
        'phone_otp',
        'email_otp',
        'signature',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_name' => 'string',
        'middle_name' => 'string',
        'last_name' => 'string',
        'address' => 'string',
        'password' => 'string',
        'code' => 'string',
        'phone' => 'string',
        'revenue' => 'string',
        'car_no' => 'string',
        'licence' => 'string',
        'isAvailable' => 'string',
        'status' => 'string',
        'email' => 'string',
        'device_token' => 'string',
        'referal_code' => 'string',
        'penalty' => 'string',
        'device_type' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'apartment' => 'string',
        'image' => 'string',
        'licence_expire' => 'string',
        'discount' => 'string',
        'ssn' => 'string',
        'car_inspection' => 'string',
        'car_reg' => 'string',
        'car_insurance' => 'string',
        'driving_licence' => 'string',
        'activated' => 'string',
        'basic_details' => 'string',
        'address_details' => 'string',
        'licence_details' => 'string',
        'documents' => 'string',
        'phone_otp' => 'string',
        'email_otp' => 'string',
        'signature' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
