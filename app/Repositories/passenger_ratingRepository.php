<?php

namespace App\Repositories;

use App\Models\passenger_rating;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class passenger_ratingRepository
 * @package App\Repositories
 * @version March 23, 2019, 7:41 am UTC
 *
 * @method passenger_rating findWithoutFail($id, $columns = ['*'])
 * @method passenger_rating find($id, $columns = ['*'])
 * @method passenger_rating first($columns = ['*'])
*/
class passenger_ratingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'bookingid',
        'userid',
        'driverid',
        'rating',
        'comments'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return passenger_rating::class;
    }
}
