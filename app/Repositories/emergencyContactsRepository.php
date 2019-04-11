<?php

namespace App\Repositories;

use App\Models\emergencyContacts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class emergencyContactsRepository
 * @package App\Repositories
 * @version April 11, 2019, 1:22 am MDT
 *
 * @method emergencyContacts findWithoutFail($id, $columns = ['*'])
 * @method emergencyContacts find($id, $columns = ['*'])
 * @method emergencyContacts first($columns = ['*'])
*/
class emergencyContactsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'phone'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return emergencyContacts::class;
    }
}
