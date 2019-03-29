<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class example
 * @package App\Models
 * @version March 25, 2019, 7:08 am UTC
 *
 * @property string aa
 * @property string bb
 */
class example extends Model
{
    use SoftDeletes;

    public $table = 'examples';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'aa',
        'bb'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'aa' => 'string',
        'bb' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
