<?php

namespace App\Repositories;

use App\Models\passengerStripe;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class passengerStripeRepository
 * @package App\Repositories
 * @version February 27, 2019, 11:55 am UTC
 *
 * @method passengerStripe findWithoutFail($id, $columns = ['*'])
 * @method passengerStripe find($id, $columns = ['*'])
 * @method passengerStripe first($columns = ['*'])
*/
class passengerStripeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'cardNo',
        'fingerprint',
        'token',
        'brand',
        'customerId',
        'digits'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return passengerStripe::class;
    }
}
