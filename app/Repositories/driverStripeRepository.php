<?php

namespace App\Repositories;

use App\Models\driverStripe;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverStripeRepository
 * @package App\Repositories
 * @version May 11, 2019, 12:49 am MDT
 *
 * @method driverStripe findWithoutFail($id, $columns = ['*'])
 * @method driverStripe find($id, $columns = ['*'])
 * @method driverStripe first($columns = ['*'])
*/
class driverStripeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'cardNo',
        'fingerprint',
        'status',
        'token',
        'brand',
        'customerId',
        'digits'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverStripe::class;
    }
}
