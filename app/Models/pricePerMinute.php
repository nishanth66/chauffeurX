<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class pricePerMinute
 * @package App\Models
 * @version April 22, 2019, 10:28 pm MDT
 *
 * @property string category
 * @property string amount
 * @property string city
 */
class pricePerMinute extends Model
{
    use SoftDeletes;

    public $table = 'price_per_minutes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'category',
        'amount',
        'city'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category' => 'string',
        'amount' => 'string',
        'city' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
