<?php

namespace App\Repositories;

use App\Models\minimumFare;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class minimumFareRepository
 * @package App\Repositories
 * @version April 22, 2019, 10:38 pm MDT
 *
 * @method minimumFare findWithoutFail($id, $columns = ['*'])
 * @method minimumFare find($id, $columns = ['*'])
 * @method minimumFare first($columns = ['*'])
*/
class minimumFareRepository extends BaseRepository
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
        return minimumFare::class;
    }
}
