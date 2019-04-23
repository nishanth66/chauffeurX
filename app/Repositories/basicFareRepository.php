<?php

namespace App\Repositories;

use App\Models\basicFare;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class basicFareRepository
 * @package App\Repositories
 * @version April 22, 2019, 10:35 pm MDT
 *
 * @method basicFare findWithoutFail($id, $columns = ['*'])
 * @method basicFare find($id, $columns = ['*'])
 * @method basicFare first($columns = ['*'])
*/
class basicFareRepository extends BaseRepository
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
        return basicFare::class;
    }
}
