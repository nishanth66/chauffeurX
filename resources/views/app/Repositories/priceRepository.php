<?php

namespace App\Repositories;

use App\Models\price;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class priceRepository
 * @package App\Repositories
 * @version March 1, 2019, 6:37 am UTC
 *
 * @method price findWithoutFail($id, $columns = ['*'])
 * @method price find($id, $columns = ['*'])
 * @method price first($columns = ['*'])
*/
class priceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return price::class;
    }
}
