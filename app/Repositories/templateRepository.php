<?php

namespace App\Repositories;

use App\Models\template;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class templateRepository
 * @package App\Repositories
 * @version April 10, 2019, 3:12 am MDT
 *
 * @method template findWithoutFail($id, $columns = ['*'])
 * @method template find($id, $columns = ['*'])
 * @method template first($columns = ['*'])
*/
class templateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'title',
        'image',
        'message'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return template::class;
    }
}
