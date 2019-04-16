<?php

use Faker\Factory as Faker;
use App\Models\preferences;
use App\Repositories\preferencesRepository;

trait MakepreferencesTrait
{
    /**
     * Create fake instance of preferences and save it in database
     *
     * @param array $preferencesFields
     * @return preferences
     */
    public function makepreferences($preferencesFields = [])
    {
        /** @var preferencesRepository $preferencesRepo */
        $preferencesRepo = App::make(preferencesRepository::class);
        $theme = $this->fakepreferencesData($preferencesFields);
        return $preferencesRepo->create($theme);
    }

    /**
     * Get fake instance of preferences
     *
     * @param array $preferencesFields
     * @return preferences
     */
    public function fakepreferences($preferencesFields = [])
    {
        return new preferences($this->fakepreferencesData($preferencesFields));
    }

    /**
     * Get fake data of preferences
     *
     * @param array $postFields
     * @return array
     */
    public function fakepreferencesData($preferencesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'type_of_music' => $fake->text,
            'like_to_talk_or_not' => $fake->text,
            'like_to_have_the_door_opened' => $fake->text,
            'temperature' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $preferencesFields);
    }
}
