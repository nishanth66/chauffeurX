<?php

use Faker\Factory as Faker;
use App\Models\driverCategory;
use App\Repositories\driverCategoryRepository;

trait MakedriverCategoryTrait
{
    /**
     * Create fake instance of driverCategory and save it in database
     *
     * @param array $driverCategoryFields
     * @return driverCategory
     */
    public function makedriverCategory($driverCategoryFields = [])
    {
        /** @var driverCategoryRepository $driverCategoryRepo */
        $driverCategoryRepo = App::make(driverCategoryRepository::class);
        $theme = $this->fakedriverCategoryData($driverCategoryFields);
        return $driverCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of driverCategory
     *
     * @param array $driverCategoryFields
     * @return driverCategory
     */
    public function fakedriverCategory($driverCategoryFields = [])
    {
        return new driverCategory($this->fakedriverCategoryData($driverCategoryFields));
    }

    /**
     * Get fake data of driverCategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakedriverCategoryData($driverCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'driverid' => $fake->text,
            'categoryid' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $driverCategoryFields);
    }
}
