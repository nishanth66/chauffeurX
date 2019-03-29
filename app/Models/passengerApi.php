<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class passengerApi
 * @package App\Models
 * @version March 1, 2019, 7:51 am UTC
 *
 * @property string link
 * @property string method
 * @property string parameters
 * @property string name
 */
class passengerApi extends Model
{
    use SoftDeletes;

    public $table = 'passenger_apis';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'link',
        'method',
        'parameters',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'link' => 'string',
        'method' => 'string',
        'parameters' => 'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
