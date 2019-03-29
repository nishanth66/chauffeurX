<?php

use Faker\Factory as Faker;
use App\Models\example;
use App\Repositories\exampleRepository;

trait MakeexampleTrait
{
    /**
     * Create fake instance of example and save it in database
     *
     * @param array $exampleFields
     * @return example
     */
    public function makeexample($exampleFields = [])
    {
        /** @var exampleRepository $exampleRepo */
        $exampleRepo = App::make(exampleRepository::class);
        $theme = $this->fakeexampleData($exampleFields);
        return $exampleRepo->create($theme);
    }

    /**
     * Get fake instance of example
     *
     * @param array $exampleFields
     * @return example
     */
    public function fakeexample($exampleFields = [])
    {
        return new example($this->fakeexampleData($exampleFields));
    }

    /**
     * Get fake data of example
     *
     * @param array $postFields
     * @return array
     */
    public function fakeexampleData($exampleFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'aa' => $fake->text,
            'bb' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $exampleFields);
    }
}
