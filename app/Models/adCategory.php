<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class adCategory
 * @package App\Models
 * @version June 6, 2019, 10:58 pm MDT
 *
 * @property string city
 * @property string name
 */
class adCategory extends Model
{
    use SoftDeletes;

    public $table = 'ad_categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'city',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'city' => 'string',
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
