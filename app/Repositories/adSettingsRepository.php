<?php

namespace App\Repositories;

use App\Models\adSettings;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class adSettingsRepository
 * @package App\Repositories
 * @version June 6, 2019, 5:50 am MDT
 *
 * @method adSettings findWithoutFail($id, $columns = ['*'])
 * @method adSettings find($id, $columns = ['*'])
 * @method adSettings first($columns = ['*'])
*/
class adSettingsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city',
        'view_cost',
        'category_view_cost',
        'max_distance'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return adSettings::class;
    }
}
