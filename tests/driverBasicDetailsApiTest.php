<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class driverBasicDetailsApiTest extends TestCase
{
    use MakedriverBasicDetailsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatedriverBasicDetails()
    {
        $driverBasicDetails = $this->fakedriverBasicDetailsData();
        $this->json('POST', '/api/v1/driverBasicDetails', $driverBasicDetails);

        $this->assertApiResponse($driverBasicDetails);
    }

    /**
     * @test
     */
    public function testReaddriverBasicDetails()
    {
        $driverBasicDetails = $this->makedriverBasicDetails();
        $this->json('GET', '/api/v1/driverBasicDetails/'.$driverBasicDetails->id);

        $this->assertApiResponse($driverBasicDetails->toArray());
    }

    /**
     * @test
     */
    public function testUpdatedriverBasicDetails()
    {
        $driverBasicDetails = $this->makedriverBasicDetails();
        $editeddriverBasicDetails = $this->fakedriverBasicDetailsData();

        $this->json('PUT', '/api/v1/driverBasicDetails/'.$driverBasicDetails->id, $editeddriverBasicDetails);

        $this->assertApiResponse($editeddriverBasicDetails);
    }

    /**
     * @test
     */
    public function testDeletedriverBasicDetails()
    {
        $driverBasicDetails = $this->makedriverBasicDetails();
        $this->json('DELETE', '/api/v1/driverBasicDetails/'.$driverBasicDetails->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/driverBasicDetails/'.$driverBasicDetails->id);

        $this->assertResponseStatus(404);
    }
}
