<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class price
 * @package App\Models
 * @version March 1, 2019, 6:37 am UTC
 *
 * @property string category
 * @property string amount
 */
class price extends Model
{
    use SoftDeletes;

    public $table = 'prices';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'category',
        'city',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category' => 'string',
        'city' => 'string',
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
