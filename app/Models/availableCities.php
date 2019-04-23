<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class availableCities
 * @package App\Models
 * @version April 22, 2019, 10:25 pm MDT
 *
 * @property string city
 * @property string start_date
 */
class availableCities extends Model
{
    use SoftDeletes;

    public $table = 'available_cities';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'city',
        'start_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'city' => 'string',
        'start_date' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
