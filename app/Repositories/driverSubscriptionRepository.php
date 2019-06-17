<?php

namespace App\Repositories;

use App\Models\driverSubscription;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class driverSubscriptionRepository
 * @package App\Repositories
 * @version May 29, 2019, 10:19 pm MDT
 *
 * @method driverSubscription findWithoutFail($id, $columns = ['*'])
 * @method driverSubscription find($id, $columns = ['*'])
 * @method driverSubscription first($columns = ['*'])
*/
class driverSubscriptionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city',
        'category',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return driverSubscription::class;
    }
}
