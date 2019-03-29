<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class driverCategoryApiTest extends TestCase
{
    use MakedriverCategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatedriverCategory()
    {
        $driverCategory = $this->fakedriverCategoryData();
        $this->json('POST', '/api/v1/driverCategories', $driverCategory);

        $this->assertApiResponse($driverCategory);
    }

    /**
     * @test
     */
    public function testReaddriverCategory()
    {
        $driverCategory = $this->makedriverCategory();
        $this->json('GET', '/api/v1/driverCategories/'.$driverCategory->id);

        $this->assertApiResponse($driverCategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdatedriverCategory()
    {
        $driverCategory = $this->makedriverCategory();
        $editeddriverCategory = $this->fakedriverCategoryData();

        $this->json('PUT', '/api/v1/driverCategories/'.$driverCategory->id, $editeddriverCategory);

        $this->assertApiResponse($editeddriverCategory);
    }

    /**
     * @test
     */
    public function testDeletedriverCategory()
    {
        $driverCategory = $this->makedriverCategory();
        $this->json('DELETE', '/api/v1/driverCategories/'.$driverCategory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/driverCategories/'.$driverCategory->id);

        $this->assertResponseStatus(404);
    }
}
