<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class userCoupons
 * @package App\Models
 * @version April 3, 2019, 1:04 am MDT
 *
 * @property string userid
 * @property string code
 * @property string status
 * @property string discount
 * @property string expire
 */
class userCoupons extends Model
{
    use SoftDeletes;

    public $table = 'user_coupons';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'userid',
        'code',
        'status',
        'discount',
        'expire'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'userid' => 'string',
        'code' => 'string',
        'status' => 'string',
        'discount' => 'string',
        'expire' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
