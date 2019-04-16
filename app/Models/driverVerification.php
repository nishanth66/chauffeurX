<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class driverVerification
 * @package App\Models
 * @version April 15, 2019, 12:16 am MDT
 *
 * @property string licence
 * @property string licence_expire
 * @property string car_inspection
 * @property string car_reg
 * @property string car_insurance
 * @property string driving_licence
 */
class driverVerification extends Model
{
    use SoftDeletes;

    public $table = 'driver_verifications';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'driverid',
        'licence',
        'licence_expire',
        'car_inspection',
        'car_reg',
        'car_insurance',
        'driving_licence',
        'ssn',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'driverid' => 'string',
        'licence' => 'string',
        'licence_expire' => 'string',
        'car_inspection' => 'string',
        'car_reg' => 'string',
        'car_insurance' => 'string',
        'driving_licence' => 'string',
        'ssn' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
