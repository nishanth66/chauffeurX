<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class notification
 * @package App\Models
 * @version April 10, 2019, 3:04 am MDT
 *
 * @property string type
 * @property string title
 * @property string image
 * @property string message
 * @property string read
 */
class notification extends Model
{
    use SoftDeletes;

    public $table = 'notifications';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'userid',
        'title',
        'image',
        'message',
        'read'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'userid' => 'string',
        'title' => 'string',
        'image' => 'string',
        'message' => 'string',
        'read' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
