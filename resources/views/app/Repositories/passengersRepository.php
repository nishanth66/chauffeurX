<?php

namespace App\Repositories;

use App\Models\passengers;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class passengersRepository
 * @package App\Repositories
 * @version March 22, 2019, 12:25 pm UTC
 *
 * @method passengers findWithoutFail($id, $columns = ['*'])
 * @method passengers find($id, $columns = ['*'])
 * @method passengers first($columns = ['*'])
*/
class passengersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fname',
        'lname',
        'email',
        'password',
        'phone',
        'otp',
        'exists_user',
        'payment_method',
        'stripe_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return passengers::class;
    }
}
