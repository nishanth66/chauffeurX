<?php

namespace App\Repositories;

use App\Models\cencellation;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class cencellationRepository
 * @package App\Repositories
 * @version February 26, 2019, 12:32 pm UTC
 *
 * @method cencellation findWithoutFail($id, $columns = ['*'])
 * @method cencellation find($id, $columns = ['*'])
 * @method cencellation first($columns = ['*'])
*/
class cencellationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'amount',
        'terms'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return cencellation::class;
    }
}
