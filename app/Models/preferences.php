<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class preferences
 * @package App\Models
 * @version April 16, 2019, 12:58 am MDT
 *
 * @property string type_of_music
 * @property string like_to_talk_or_not
 * @property string like_to_have_the_door_opened
 * @property string temperature
 */
class preferences extends Model
{
    use SoftDeletes;

    public $table = 'preferences';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'userid',
        'type_of_music',
        'like_to_talk_or_not',
        'like_to_have_the_door_opened',
        'temperature'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'userid' => 'string',
        'type_of_music' => 'string',
        'like_to_talk_or_not' => 'string',
        'like_to_have_the_door_opened' => 'string',
        'temperature' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
