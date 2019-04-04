<?php

namespace App\Repositories;

use App\Models\favDriver;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class favDriverRepository
 * @package App\Repositories
 * @version February 26, 2019, 10:28 am UTC
 *
 * @method favDriver findWithoutFail($id, $columns = ['*'])
 * @method favDriver find($id, $columns = ['*'])
 * @method favDriver first($columns = ['*'])
*/
class favDriverRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'driverid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return favDriver::class;
    }
}
