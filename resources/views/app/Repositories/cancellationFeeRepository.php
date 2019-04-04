<?php

namespace App\Repositories;

use App\Models\cancellationFee;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class cancellationFeeRepository
 * @package App\Repositories
 * @version February 28, 2019, 9:27 am UTC
 *
 * @method cancellationFee findWithoutFail($id, $columns = ['*'])
 * @method cancellationFee find($id, $columns = ['*'])
 * @method cancellationFee first($columns = ['*'])
*/
class cancellationFeeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return cancellationFee::class;
    }
}
