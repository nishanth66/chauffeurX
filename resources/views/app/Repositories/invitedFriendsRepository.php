<?php

namespace App\Repositories;

use App\Models\invitedFriends;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class invitedFriendsRepository
 * @package App\Repositories
 * @version March 22, 2019, 4:59 am UTC
 *
 * @method invitedFriends findWithoutFail($id, $columns = ['*'])
 * @method invitedFriends find($id, $columns = ['*'])
 * @method invitedFriends first($columns = ['*'])
*/
class invitedFriendsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'phone',
        'date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return invitedFriends::class;
    }
}
