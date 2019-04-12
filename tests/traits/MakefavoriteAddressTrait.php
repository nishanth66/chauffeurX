<?php

use Faker\Factory as Faker;
use App\Models\favoriteAddress;
use App\Repositories\favoriteAddressRepository;

trait MakefavoriteAddressTrait
{
    /**
     * Create fake instance of favoriteAddress and save it in database
     *
     * @param array $favoriteAddressFields
     * @return favoriteAddress
     */
    public function makefavoriteAddress($favoriteAddressFields = [])
    {
        /** @var favoriteAddressRepository $favoriteAddressRepo */
        $favoriteAddressRepo = App::make(favoriteAddressRepository::class);
        $theme = $this->fakefavoriteAddressData($favoriteAddressFields);
        return $favoriteAddressRepo->create($theme);
    }

    /**
     * Get fake instance of favoriteAddress
     *
     * @param array $favoriteAddressFields
     * @return favoriteAddress
     */
    public function fakefavoriteAddress($favoriteAddressFields = [])
    {
        return new favoriteAddress($this->fakefavoriteAddressData($favoriteAddressFields));
    }

    /**
     * Get fake data of favoriteAddress
     *
     * @param array $postFields
     * @return array
     */
    public function fakefavoriteAddressData($favoriteAddressFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->text,
            'lat' => $fake->text,
            'lng' => $fake->text,
            'address' => $fake->text,
            'image' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $favoriteAddressFields);
    }
}
