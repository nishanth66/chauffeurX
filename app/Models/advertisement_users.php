<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class advertisement_users
 * @package App\Models
 * @version April 27, 2019, 3:44 am MDT
 *
 * @property string fname
 * @property string lname
 * @property string mname
 * @property string email
 * @property string phone
 * @property string address
 * @property string city
 * @property string state
 * @property string zip
 * @property string country
 * @property string suite_number
 * @property string ad_budget
 * @property string activated
 * @property string userid
 * @property string basic_details
 * @property string address_details
 */
class advertisement_users extends Model
{
    use SoftDeletes;

    public $table = 'advertisement_users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'fname',
        'lname',
        'mname',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'suite_number',
        'ad_budget',
        'activated',
        'userid',
        'basic_details',
        'address_details',
        'email_otp',
        'code',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fname' => 'string',
        'lname' => 'string',
        'mname' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zip' => 'string',
        'country' => 'string',
        'suite_number' => 'string',
        'ad_budget' => 'string',
        'activated' => 'string',
        'userid' => 'string',
        'basic_details' => 'string',
        'address_details' => 'string',
        'email_otp' => 'string',
        'code' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
