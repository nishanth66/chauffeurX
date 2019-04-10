<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class template
 * @package App\Models
 * @version April 10, 2019, 3:12 am MDT
 *
 * @property string type
 * @property string title
 * @property string image
 * @property string message
 */
class template extends Model
{
    use SoftDeletes;

    public $table = 'templates';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'title',
        'image',
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'title' => 'string',
        'image' => 'string',
        'message' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
