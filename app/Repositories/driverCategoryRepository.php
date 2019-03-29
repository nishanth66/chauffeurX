<?php

namespace App\Repositories;

use App\Models\driverCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverCategoryRepository
 * @package App\Repositories
 * @version March 26, 2019, 4:04 am UTC
 *
 * @method driverCategory findWithoutFail($id, $columns = ['*'])
 * @method driverCategory find($id, $columns = ['*'])
 * @method driverCategory first($columns = ['*'])
*/
class driverCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'driverid',
        'categoryid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverCategory::class;
    }
}
