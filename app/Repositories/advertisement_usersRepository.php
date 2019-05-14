<?php

namespace App\Repositories;

use App\Models\advertisement_users;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class advertisement_usersRepository
 * @package App\Repositories
 * @version April 27, 2019, 3:44 am MDT
 *
 * @method advertisement_users findWithoutFail($id, $columns = ['*'])
 * @method advertisement_users find($id, $columns = ['*'])
 * @method advertisement_users first($columns = ['*'])
*/
class advertisement_usersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fname',
        'lname',
        'mname',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'suite_number',
        'ad_budget',
        'activated',
        'userid',
        'basic_details',
        'address_details'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return advertisement_users::class;
    }
}
