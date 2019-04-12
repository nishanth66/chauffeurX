<?php

namespace App\Repositories;

use App\Models\rank;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class rankRepository
 * @package App\Repositories
 * @version April 12, 2019, 4:40 am MDT
 *
 * @method rank findWithoutFail($id, $columns = ['*'])
 * @method rank find($id, $columns = ['*'])
 * @method rank first($columns = ['*'])
*/
class rankRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'points',
        'discount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return rank::class;
    }
}
