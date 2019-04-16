<?php

namespace App\Repositories;

use App\Models\driverVerification;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverVerificationRepository
 * @package App\Repositories
 * @version April 15, 2019, 12:16 am MDT
 *
 * @method driverVerification findWithoutFail($id, $columns = ['*'])
 * @method driverVerification find($id, $columns = ['*'])
 * @method driverVerification first($columns = ['*'])
*/
class driverVerificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'licence',
        'licence_expire',
        'car_inspection',
        'car_reg',
        'car_insurance',
        'driving_licence'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverVerification::class;
    }
}
