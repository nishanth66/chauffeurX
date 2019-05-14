<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class passengers
 * @package App\Models
 * @version March 22, 2019, 12:25 pm UTC
 *
 * @property string fname
 * @property string lname
 * @property string email
 * @property string password
 * @property string phone
 * @property string otp
 * @property string exists_user
 * @property string payment_method
 * @property string stripe_id
 */
class passengers extends Model
{
    use SoftDeletes;

    public $table = 'passengers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'phone',
        'new_phone',
        'otp',
        'exists_user',
        'payment_method',
        'stripe_id',
        'referral_code',
        'gender',
        'passengers',
        'firebase_key',
        'device_token',
        'device_type',
        'activated',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'fname' => 'string',
        'lname' => 'string',
        'email' => 'string',
        'password' => 'string',
        'phone' => 'string',
        'new_phone' => 'string',
        'otp' => 'string',
        'exists_user' => 'string',
        'payment_method' => 'string',
        'stripe_id' => 'string',
        'referral_code' => 'string',
        'gender' => 'string',
        'passengers' => 'string',
        'firebase_key' => 'string',
        'device_token' => 'string',
        'device_type' => 'string',
        'activated' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
