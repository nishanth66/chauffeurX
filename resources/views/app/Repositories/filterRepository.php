<?php

namespace App\Repositories;

use App\Models\filter;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class filterRepository
 * @package App\Repositories
 * @version March 29, 2019, 3:25 am MDT
 *
 * @method filter findWithoutFail($id, $columns = ['*'])
 * @method filter find($id, $columns = ['*'])
 * @method filter first($columns = ['*'])
*/
class filterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return filter::class;
    }
}
