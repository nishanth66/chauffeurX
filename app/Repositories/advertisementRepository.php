<?php

namespace App\Repositories;

use App\Models\advertisement;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class advertisementRepository
 * @package App\Repositories
 * @version March 12, 2019, 9:13 am UTC
 *
 * @method advertisement findWithoutFail($id, $columns = ['*'])
 * @method advertisement find($id, $columns = ['*'])
 * @method advertisement first($columns = ['*'])
*/
class advertisementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'image',
        'place',
        'lat'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return advertisement::class;
    }
}
