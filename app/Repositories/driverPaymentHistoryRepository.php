<?php

namespace App\Repositories;

use App\Models\driverPaymentHistory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverPaymentHistoryRepository
 * @package App\Repositories
 * @version May 29, 2019, 10:53 pm MDT
 *
 * @method driverPaymentHistory findWithoutFail($id, $columns = ['*'])
 * @method driverPaymentHistory find($id, $columns = ['*'])
 * @method driverPaymentHistory first($columns = ['*'])
*/
class driverPaymentHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'driverid',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverPaymentHistory::class;
    }
}
