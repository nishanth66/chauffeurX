<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverApi
 * @package App\Models
 * @version March 22, 2019, 1:07 pm UTC
 *
 * @property string name
 * @property string link
 * @property string method
 * @property string parameters
 */
class driverApi extends Model
{
    use SoftDeletes;

    public $table = 'driver_apis';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'link',
        'method',
        'parameters'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'link' => 'string',
        'method' => 'string',
        'parameters' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
