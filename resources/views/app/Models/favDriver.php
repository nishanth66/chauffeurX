<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class favDriver
 * @package App\Models
 * @version February 26, 2019, 10:28 am UTC
 *
 * @property string userid
 * @property string driverid
 */
class favDriver extends Model
{
    use SoftDeletes;

    public $table = 'fav_drivers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'userid',
        'driverid'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'userid' => 'string',
        'driverid' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
