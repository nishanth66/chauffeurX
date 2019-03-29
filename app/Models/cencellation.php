<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class cencellation
 * @package App\Models
 * @version February 26, 2019, 12:32 pm UTC
 *
 * @property string amount
 * @property string terms
 */
class cencellation extends Model
{
    use SoftDeletes;

    public $table = 'cencellations';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'amount',
        'terms',
        'max_time',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'string',
        'terms' => 'string',
        'max_time' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
