<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class emergencyContacts
 * @package App\Models
 * @version April 11, 2019, 1:22 am MDT
 *
 * @property string name
 * @property string phone
 */
class emergencyContacts extends Model
{
    use SoftDeletes;

    public $table = 'emergency_contacts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'phone',
        'userid',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'userid' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
