<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class invitedFriends
 * @package App\Models
 * @version March 22, 2019, 4:59 am UTC
 *
 * @property string name
 * @property string phone
 * @property string date
 */
class invitedFriends extends Model
{
    use SoftDeletes;

    public $table = 'invited_friends';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'phone',
        'date',
        'invite_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'date' => 'string',
        'invite_id' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
