<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class adSettings
 * @package App\Models
 * @version June 6, 2019, 5:50 am MDT
 *
 * @property string city
 * @property string view_cost
 * @property string category_view_cost
 * @property string max_distance
 */
class adSettings extends Model
{
    use SoftDeletes;

    public $table = 'ad_settings';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'city',
        'view_cost',
        'category_view_cost',
        'max_distance'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'city' => 'string',
        'view_cost' => 'string',
        'category_view_cost' => 'string',
        'max_distance' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'city' => 'required'
    ];

    
}
