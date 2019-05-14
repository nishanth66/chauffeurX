<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverNotification
 * @package App\Models
 * @version April 24, 2019, 3:27 am MDT
 *
 * @property string driverid
 * @property string type
 * @property string title
 * @property string image
 * @property string message
 * @property string read
 */
class driverNotification extends Model
{
    use SoftDeletes;

    public $table = 'driver_notifications';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'driverid',
        'type',
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
        'id' => 'integer',
        'driverid' => 'string',
        'type' => 'string',
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
        'message' => 'null'
    ];

    
}
