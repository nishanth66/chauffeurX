<?php

namespace App\Repositories;

use App\Models\driverPayment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverPaymentRepository
 * @package App\Repositories
 * @version May 11, 2019, 1:15 am MDT
 *
 * @method driverPayment findWithoutFail($id, $columns = ['*'])
 * @method driverPayment find($id, $columns = ['*'])
 * @method driverPayment first($columns = ['*'])
*/
class driverPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'driverid',
        'amount',
        'cardid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverPayment::class;
    }
}
