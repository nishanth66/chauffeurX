<?php

namespace App\Repositories;

use App\Models\availableCities;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class availableCitiesRepository
 * @package App\Repositories
 * @version April 22, 2019, 10:25 pm MDT
 *
 * @method availableCities findWithoutFail($id, $columns = ['*'])
 * @method availableCities find($id, $columns = ['*'])
 * @method availableCities first($columns = ['*'])
*/
class availableCitiesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city',
        'start_date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return availableCities::class;
    }
}
