<?php

use Faker\Factory as Faker;
use App\Models\emergencyContacts;
use App\Repositories\emergencyContactsRepository;

trait MakeemergencyContactsTrait
{
    /**
     * Create fake instance of emergencyContacts and save it in database
     *
     * @param array $emergencyContactsFields
     * @return emergencyContacts
     */
    public function makeemergencyContacts($emergencyContactsFields = [])
    {
        /** @var emergencyContactsRepository $emergencyContactsRepo */
        $emergencyContactsRepo = App::make(emergencyContactsRepository::class);
        $theme = $this->fakeemergencyContactsData($emergencyContactsFields);
        return $emergencyContactsRepo->create($theme);
    }

    /**
     * Get fake instance of emergencyContacts
     *
     * @param array $emergencyContactsFields
     * @return emergencyContacts
     */
    public function fakeemergencyContacts($emergencyContactsFields = [])
    {
        return new emergencyContacts($this->fakeemergencyContactsData($emergencyContactsFields));
    }

    /**
     * Get fake data of emergencyContacts
     *
     * @param array $postFields
     * @return array
     */
    public function fakeemergencyContactsData($emergencyContactsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->text,
            'phone' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $emergencyContactsFields);
    }
}
