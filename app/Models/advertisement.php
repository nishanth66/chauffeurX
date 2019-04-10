<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class advertisement
 * @package App\Models
 * @version March 12, 2019, 9:13 am UTC
 *
 * @property string name
 * @property string description
 * @property string image
 * @property string place
 * @property string lat
 */
class advertisement extends Model
{
    use SoftDeletes;

    public $table = 'advertisements';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'image',
        'address',
        'lat',
        'lng',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'image' => 'string',
        'address' => 'string',
        'lat' => 'string',
        'lng' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    
}
