<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class driverVerificationApiTest extends TestCase
{
    use MakedriverVerificationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatedriverVerification()
    {
        $driverVerification = $this->fakedriverVerificationData();
        $this->json('POST', '/api/v1/driverVerifications', $driverVerification);

        $this->assertApiResponse($driverVerification);
    }

    /**
     * @test
     */
    public function testReaddriverVerification()
    {
        $driverVerification = $this->makedriverVerification();
        $this->json('GET', '/api/v1/driverVerifications/'.$driverVerification->id);

        $this->assertApiResponse($driverVerification->toArray());
    }

    /**
     * @test
     */
    public function testUpdatedriverVerification()
    {
        $driverVerification = $this->makedriverVerification();
        $editeddriverVerification = $this->fakedriverVerificationData();

        $this->json('PUT', '/api/v1/driverVerifications/'.$driverVerification->id, $editeddriverVerification);

        $this->assertApiResponse($editeddriverVerification);
    }

    /**
     * @test
     */
    public function testDeletedriverVerification()
    {
        $driverVerification = $this->makedriverVerification();
        $this->json('DELETE', '/api/v1/driverVerifications/'.$driverVerification->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/driverVerifications/'.$driverVerification->id);

        $this->assertResponseStatus(404);
    }
}
