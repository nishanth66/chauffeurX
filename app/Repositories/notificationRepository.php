<?php

namespace App\Repositories;

use App\Models\notification;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class notificationRepository
 * @package App\Repositories
 * @version April 10, 2019, 3:04 am MDT
 *
 * @method notification findWithoutFail($id, $columns = ['*'])
 * @method notification find($id, $columns = ['*'])
 * @method notification first($columns = ['*'])
*/
class notificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'title',
        'image',
        'message',
        'read'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return notification::class;
    }
}
