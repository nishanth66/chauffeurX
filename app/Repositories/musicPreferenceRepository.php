<?php

namespace App\Repositories;

use App\Models\musicPreference;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class musicPreferenceRepository
 * @package App\Repositories
 * @version April 16, 2019, 12:49 am MDT
 *
 * @method musicPreference findWithoutFail($id, $columns = ['*'])
 * @method musicPreference find($id, $columns = ['*'])
 * @method musicPreference first($columns = ['*'])
*/
class musicPreferenceRepository extends BaseRepository
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
        return musicPreference::class;
    }
}
