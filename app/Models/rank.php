<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class rank
 * @package App\Models
 * @version April 12, 2019, 4:40 am MDT
 *
 * @property string name
 * @property string image
 * @property string points
 * @property string discount
 */
class rank extends Model
{
    use SoftDeletes;

    public $table = 'ranks';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'points',
        'discount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'points' => 'string',
        'discount' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
