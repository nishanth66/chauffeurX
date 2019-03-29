<?php

namespace App\Repositories;

use App\Models\driver;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverRepository
 * @package App\Repositories
 * @version February 26, 2019, 10:41 am UTC
 *
 * @method driver findWithoutFail($id, $columns = ['*'])
 * @method driver find($id, $columns = ['*'])
 * @method driver first($columns = ['*'])
*/
class driverRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fname',
        'lname',
        'image',
        'phone',
        'car_no',
        'licence',
        'isAvailable',
        'status',
        'email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driver::class;
    }
}
