<?php

namespace App\Repositories;

use App\Models\passengerApi;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class passengerApiRepository
 * @package App\Repositories
 * @version March 1, 2019, 7:51 am UTC
 *
 * @method passengerApi findWithoutFail($id, $columns = ['*'])
 * @method passengerApi find($id, $columns = ['*'])
 * @method passengerApi first($columns = ['*'])
*/
class passengerApiRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'link',
        'method',
        'parameters',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return passengerApi::class;
    }
}
