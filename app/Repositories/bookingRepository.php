<?php

namespace App\Repositories;

use App\Models\booking;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class bookingRepository
 * @package App\Repositories
 * @version February 26, 2019, 10:15 am UTC
 *
 * @method booking findWithoutFail($id, $columns = ['*'])
 * @method booking find($id, $columns = ['*'])
 * @method booking first($columns = ['*'])
*/
class bookingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'phone',
        'completed',
        'source',
        'destination',
        'price',
        'distance',
        'trip_date',
        'trip_time',
        'source_description',
        'destination_description',
        'alternate_phone',
        'statu',
        'image',
        'payment',
        'paid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return booking::class;
    }
}
