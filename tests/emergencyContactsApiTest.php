<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class emergencyContactsApiTest extends TestCase
{
    use MakeemergencyContactsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateemergencyContacts()
    {
        $emergencyContacts = $this->fakeemergencyContactsData();
        $this->json('POST', '/api/v1/emergencyContacts', $emergencyContacts);

        $this->assertApiResponse($emergencyContacts);
    }

    /**
     * @test
     */
    public function testReademergencyContacts()
    {
        $emergencyContacts = $this->makeemergencyContacts();
        $this->json('GET', '/api/v1/emergencyContacts/'.$emergencyContacts->id);

        $this->assertApiResponse($emergencyContacts->toArray());
    }

    /**
     * @test
     */
    public function testUpdateemergencyContacts()
    {
        $emergencyContacts = $this->makeemergencyContacts();
        $editedemergencyContacts = $this->fakeemergencyContactsData();

        $this->json('PUT', '/api/v1/emergencyContacts/'.$emergencyContacts->id, $editedemergencyContacts);

        $this->assertApiResponse($editedemergencyContacts);
    }

    /**
     * @test
     */
    public function testDeleteemergencyContacts()
    {
        $emergencyContacts = $this->makeemergencyContacts();
        $this->json('DELETE', '/api/v1/emergencyContacts/'.$emergencyContacts->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/emergencyContacts/'.$emergencyContacts->id);

        $this->assertResponseStatus(404);
    }
}
