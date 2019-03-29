<?php

namespace App\Repositories;

use App\Models\rating;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ratingRepository
 * @package App\Repositories
 * @version February 26, 2019, 11:02 am UTC
 *
 * @method rating findWithoutFail($id, $columns = ['*'])
 * @method rating find($id, $columns = ['*'])
 * @method rating first($columns = ['*'])
*/
class ratingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'booking_id',
        'driverid',
        'rating',
        'comments'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return rating::class;
    }
}
