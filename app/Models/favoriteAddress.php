<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class favoriteAddress
 * @package App\Models
 * @version April 11, 2019, 3:38 am MDT
 *
 * @property string title
 * @property string lat
 * @property string lng
 * @property string address
 * @property string image
 */
class favoriteAddress extends Model
{
    use SoftDeletes;

    public $table = 'favorite_addresses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'userid',
        'lat',
        'lng',
        'address',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'userid' => 'string',
        'lat' => 'string',
        'lng' => 'string',
        'address' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
