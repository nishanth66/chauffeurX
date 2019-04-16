<?php

namespace App\Repositories;

use App\Models\preferences;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class preferencesRepository
 * @package App\Repositories
 * @version April 16, 2019, 12:58 am MDT
 *
 * @method preferences findWithoutFail($id, $columns = ['*'])
 * @method preferences find($id, $columns = ['*'])
 * @method preferences first($columns = ['*'])
*/
class preferencesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type_of_music',
        'like_to_talk_or_not',
        'like_to_have_the_door_opened',
        'temperature'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return preferences::class;
    }
}
