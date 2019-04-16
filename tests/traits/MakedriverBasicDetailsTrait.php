<?php

use Faker\Factory as Faker;
use App\Models\driverBasicDetails;
use App\Repositories\driverBasicDetailsRepository;

trait MakedriverBasicDetailsTrait
{
    /**
     * Create fake instance of driverBasicDetails and save it in database
     *
     * @param array $driverBasicDetailsFields
     * @return driverBasicDetails
     */
    public function makedriverBasicDetails($driverBasicDetailsFields = [])
    {
        /** @var driverBasicDetailsRepository $driverBasicDetailsRepo */
        $driverBasicDetailsRepo = App::make(driverBasicDetailsRepository::class);
        $theme = $this->fakedriverBasicDetailsData($driverBasicDetailsFields);
        return $driverBasicDetailsRepo->create($theme);
    }

    /**
     * Get fake instance of driverBasicDetails
     *
     * @param array $driverBasicDetailsFields
     * @return driverBasicDetails
     */
    public function fakedriverBasicDetails($driverBasicDetailsFields = [])
    {
        return new driverBasicDetails($this->fakedriverBasicDetailsData($driverBasicDetailsFields));
    }

    /**
     * Get fake data of driverBasicDetails
     *
     * @param array $postFields
     * @return array
     */
    public function fakedriverBasicDetailsData($driverBasicDetailsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'driverid' => $fake->text,
            'address' => $fake->text,
            'city' => $fake->text,
            'state' => $fake->text,
            'country' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $driverBasicDetailsFields);
    }
}
