<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class favoriteAddressApiTest extends TestCase
{
    use MakefavoriteAddressTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatefavoriteAddress()
    {
        $favoriteAddress = $this->fakefavoriteAddressData();
        $this->json('POST', '/api/v1/favoriteAddresses', $favoriteAddress);

        $this->assertApiResponse($favoriteAddress);
    }

    /**
     * @test
     */
    public function testReadfavoriteAddress()
    {
        $favoriteAddress = $this->makefavoriteAddress();
        $this->json('GET', '/api/v1/favoriteAddresses/'.$favoriteAddress->id);

        $this->assertApiResponse($favoriteAddress->toArray());
    }

    /**
     * @test
     */
    public function testUpdatefavoriteAddress()
    {
        $favoriteAddress = $this->makefavoriteAddress();
        $editedfavoriteAddress = $this->fakefavoriteAddressData();

        $this->json('PUT', '/api/v1/favoriteAddresses/'.$favoriteAddress->id, $editedfavoriteAddress);

        $this->assertApiResponse($editedfavoriteAddress);
    }

    /**
     * @test
     */
    public function testDeletefavoriteAddress()
    {
        $favoriteAddress = $this->makefavoriteAddress();
        $this->json('DELETE', '/api/v1/favoriteAddresses/'.$favoriteAddress->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/favoriteAddresses/'.$favoriteAddress->id);

        $this->assertResponseStatus(404);
    }
}
