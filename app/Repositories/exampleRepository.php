<?php

namespace App\Repositories;

use App\Models\example;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class exampleRepository
 * @package App\Repositories
 * @version March 25, 2019, 7:08 am UTC
 *
 * @method example findWithoutFail($id, $columns = ['*'])
 * @method example find($id, $columns = ['*'])
 * @method example first($columns = ['*'])
*/
class exampleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'aa',
        'bb'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return example::class;
    }
}
