<?php

namespace App\Repositories;

use App\Models\adCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class adCategoryRepository
 * @package App\Repositories
 * @version June 6, 2019, 10:58 pm MDT
 *
 * @method adCategory findWithoutFail($id, $columns = ['*'])
 * @method adCategory find($id, $columns = ['*'])
 * @method adCategory first($columns = ['*'])
*/
class adCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return adCategory::class;
    }
}
