<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class minimumFare
 * @package App\Models
 * @version April 22, 2019, 10:38 pm MDT
 *
 * @property string city
 * @property string category
 * @property string amount
 */
class minimumFare extends Model
{
    use SoftDeletes;

    public $table = 'minimum_fares';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'city',
        'category',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'city' => 'string',
        'category' => 'string',
        'amount' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
