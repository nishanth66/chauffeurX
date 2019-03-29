<?php

namespace App\Repositories;

use App\Models\driverTips;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverTipsRepository
 * @package App\Repositories
 * @version February 26, 2019, 11:51 am UTC
 *
 * @method driverTips findWithoutFail($id, $columns = ['*'])
 * @method driverTips find($id, $columns = ['*'])
 * @method driverTips first($columns = ['*'])
*/
class driverTipsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'booking_id',
        'userid',
        'driverid',
        'amount',
        'comments'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverTips::class;
    }
}
