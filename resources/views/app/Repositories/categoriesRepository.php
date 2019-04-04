<?php

namespace App\Repositories;

use App\Models\categories;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class categoriesRepository
 * @package App\Repositories
 * @version March 1, 2019, 5:29 am UTC
 *
 * @method categories findWithoutFail($id, $columns = ['*'])
 * @method categories find($id, $columns = ['*'])
 * @method categories first($columns = ['*'])
*/
class categoriesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return categories::class;
    }
}
