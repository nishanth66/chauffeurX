<?php

namespace App\Repositories;

use App\Models\driverBasicDetails;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverBasicDetailsRepository
 * @package App\Repositories
 * @version April 15, 2019, 12:30 am MDT
 *
 * @method driverBasicDetails findWithoutFail($id, $columns = ['*'])
 * @method driverBasicDetails find($id, $columns = ['*'])
 * @method driverBasicDetails first($columns = ['*'])
*/
class driverBasicDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'driverid',
        'address',
        'city',
        'state',
        'country'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverBasicDetails::class;
    }
}
