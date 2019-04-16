<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class preferencesApiTest extends TestCase
{
    use MakepreferencesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatepreferences()
    {
        $preferences = $this->fakepreferencesData();
        $this->json('POST', '/api/v1/preferences', $preferences);

        $this->assertApiResponse($preferences);
    }

    /**
     * @test
     */
    public function testReadpreferences()
    {
        $preferences = $this->makepreferences();
        $this->json('GET', '/api/v1/preferences/'.$preferences->id);

        $this->assertApiResponse($preferences->toArray());
    }

    /**
     * @test
     */
    public function testUpdatepreferences()
    {
        $preferences = $this->makepreferences();
        $editedpreferences = $this->fakepreferencesData();

        $this->json('PUT', '/api/v1/preferences/'.$preferences->id, $editedpreferences);

        $this->assertApiResponse($editedpreferences);
    }

    /**
     * @test
     */
    public function testDeletepreferences()
    {
        $preferences = $this->makepreferences();
        $this->json('DELETE', '/api/v1/preferences/'.$preferences->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/preferences/'.$preferences->id);

        $this->assertResponseStatus(404);
    }
}
