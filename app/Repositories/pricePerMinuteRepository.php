<?php

namespace App\Repositories;

use App\Models\pricePerMinute;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class pricePerMinuteRepository
 * @package App\Repositories
 * @version April 22, 2019, 10:28 pm MDT
 *
 * @method pricePerMinute findWithoutFail($id, $columns = ['*'])
 * @method pricePerMinute find($id, $columns = ['*'])
 * @method pricePerMinute first($columns = ['*'])
*/
class pricePerMinuteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category',
        'amount',
        'city'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return pricePerMinute::class;
    }
}
