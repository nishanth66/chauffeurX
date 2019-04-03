<?php

namespace App\Repositories;

use App\Models\userCoupons;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class userCouponsRepository
 * @package App\Repositories
 * @version April 3, 2019, 1:04 am MDT
 *
 * @method userCoupons findWithoutFail($id, $columns = ['*'])
 * @method userCoupons find($id, $columns = ['*'])
 * @method userCoupons first($columns = ['*'])
*/
class userCouponsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'code',
        'status',
        'discount',
        'expire'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return userCoupons::class;
    }
}
