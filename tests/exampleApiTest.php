<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class exampleApiTest extends TestCase
{
    use MakeexampleTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateexample()
    {
        $example = $this->fakeexampleData();
        $this->json('POST', '/api/v1/examples', $example);

        $this->assertApiResponse($example);
    }

    /**
     * @test
     */
    public function testReadexample()
    {
        $example = $this->makeexample();
        $this->json('GET', '/api/v1/examples/'.$example->id);

        $this->assertApiResponse($example->toArray());
    }

    /**
     * @test
     */
    public function testUpdateexample()
    {
        $example = $this->makeexample();
        $editedexample = $this->fakeexampleData();

        $this->json('PUT', '/api/v1/examples/'.$example->id, $editedexample);

        $this->assertApiResponse($editedexample);
    }

    /**
     * @test
     */
    public function testDeleteexample()
    {
        $example = $this->makeexample();
        $this->json('DELETE', '/api/v1/examples/'.$example->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/examples/'.$example->id);

        $this->assertResponseStatus(404);
    }
}
