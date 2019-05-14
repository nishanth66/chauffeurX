<?php

namespace App\Repositories;

use App\Models\driverNotification;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverNotificationRepository
 * @package App\Repositories
 * @version April 24, 2019, 3:27 am MDT
 *
 * @method driverNotification findWithoutFail($id, $columns = ['*'])
 * @method driverNotification find($id, $columns = ['*'])
 * @method driverNotification first($columns = ['*'])
*/
class driverNotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'driverid',
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
        return driverNotification::class;
    }
}
