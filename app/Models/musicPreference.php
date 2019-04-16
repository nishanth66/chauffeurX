<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class musicPreference
 * @package App\Models
 * @version April 16, 2019, 12:49 am MDT
 *
 * @property string name
 */
class musicPreference extends Model
{
    use SoftDeletes;

    public $table = 'music_preferences';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
