<?php

use Faker\Factory as Faker;
use App\Models\driverVerification;
use App\Repositories\driverVerificationRepository;

trait MakedriverVerificationTrait
{
    /**
     * Create fake instance of driverVerification and save it in database
     *
     * @param array $driverVerificationFields
     * @return driverVerification
     */
    public function makedriverVerification($driverVerificationFields = [])
    {
        /** @var driverVerificationRepository $driverVerificationRepo */
        $driverVerificationRepo = App::make(driverVerificationRepository::class);
        $theme = $this->fakedriverVerificationData($driverVerificationFields);
        return $driverVerificationRepo->create($theme);
    }

    /**
     * Get fake instance of driverVerification
     *
     * @param array $driverVerificationFields
     * @return driverVerification
     */
    public function fakedriverVerification($driverVerificationFields = [])
    {
        return new driverVerification($this->fakedriverVerificationData($driverVerificationFields));
    }

    /**
     * Get fake data of driverVerification
     *
     * @param array $postFields
     * @return array
     */
    public function fakedriverVerificationData($driverVerificationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'licence' => $fake->text,
            'licence_expire' => $fake->text,
            'car_inspection' => $fake->text,
            'car_reg' => $fake->text,
            'car_insurance' => $fake->text,
            'driving_licence' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $driverVerificationFields);
    }
}
