<?php

namespace App\Repositories;

use App\Models\serviceFee;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class serviceFeeRepository
 * @package App\Repositories
 * @version April 22, 2019, 10:43 pm MDT
 *
 * @method serviceFee findWithoutFail($id, $columns = ['*'])
 * @method serviceFee find($id, $columns = ['*'])
 * @method serviceFee first($columns = ['*'])
*/
class serviceFeeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city',
        'category',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return serviceFee::class;
    }
}
