<?php

namespace App\Repositories;

use App\Models\driverApi;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverApiRepository
 * @package App\Repositories
 * @version March 22, 2019, 1:07 pm UTC
 *
 * @method driverApi findWithoutFail($id, $columns = ['*'])
 * @method driverApi find($id, $columns = ['*'])
 * @method driverApi first($columns = ['*'])
*/
class driverApiRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'link',
        'method',
        'parameters'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverApi::class;
    }
}
