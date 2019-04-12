<?php

namespace App\Repositories;

use App\Models\favoriteAddress;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class favoriteAddressRepository
 * @package App\Repositories
 * @version April 11, 2019, 3:38 am MDT
 *
 * @method favoriteAddress findWithoutFail($id, $columns = ['*'])
 * @method favoriteAddress find($id, $columns = ['*'])
 * @method favoriteAddress first($columns = ['*'])
*/
class favoriteAddressRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'lat',
        'lng',
        'address',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return favoriteAddress::class;
    }
}
