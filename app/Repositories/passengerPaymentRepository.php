<?php

namespace App\Repositories;

use App\Models\passengerPayment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class passengerPaymentRepository
 * @package App\Repositories
 * @version May 11, 2019, 1:11 am MDT
 *
 * @method passengerPayment findWithoutFail($id, $columns = ['*'])
 * @method passengerPayment find($id, $columns = ['*'])
 * @method passengerPayment first($columns = ['*'])
*/
class passengerPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'bookingid',
        'amount',
        'cardid'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return passengerPayment::class;
    }
}
