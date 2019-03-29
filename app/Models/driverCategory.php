<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverCategory
 * @package App\Models
 * @version March 26, 2019, 4:04 am UTC
 *
 * @property string driverid
 * @property string categoryid
 */
class driverCategory extends Model
{
    use SoftDeletes;

    public $table = 'driver_categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'driverid',
        'categoryid'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'driverid' => 'string',
        'categoryid' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
