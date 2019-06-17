<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AdView
 * @package App\Models
 * @version June 4, 2019, 3:53 am MDT
 *
 * @property string ad_user_id
 * @property string adId
 * @property string base_view
 * @property string category_view
 * @property string ad_cost
 * @property string date
 */
class AdView extends Model
{
    use SoftDeletes;

    public $table = 'ad_views';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'ad_user_id',
        'adId',
        'base_view',
        'category_view',
        'ad_cost',
        'date',
        'payment',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ad_user_id' => 'string',
        'adId' => 'string',
        'base_view' => 'string',
        'category_view' => 'string',
        'ad_cost' => 'string',
        'date' => 'string',
        'payment' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
