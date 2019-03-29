<?php

use App\Models\driverCategory;
use App\Repositories\driverCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class driverCategoryRepositoryTest extends TestCase
{
    use MakedriverCategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var driverCategoryRepository
     */
    protected $driverCategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->driverCategoryRepo = App::make(driverCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatedriverCategory()
    {
        $driverCategory = $this->fakedriverCategoryData();
        $createddriverCategory = $this->driverCategoryRepo->create($driverCategory);
        $createddriverCategory = $createddriverCategory->toArray();
        $this->assertArrayHasKey('id', $createddriverCategory);
        $this->assertNotNull($createddriverCategory['id'], 'Created driverCategory must have id specified');
        $this->assertNotNull(driverCategory::find($createddriverCategory['id']), 'driverCategory with given id must be in DB');
        $this->assertModelData($driverCategory, $createddriverCategory);
    }

    /**
     * @test read
     */
    public function testReaddriverCategory()
    {
        $driverCategory = $this->makedriverCategory();
        $dbdriverCategory = $this->driverCategoryRepo->find($driverCategory->id);
        $dbdriverCategory = $dbdriverCategory->toArray();
        $this->assertModelData($driverCategory->toArray(), $dbdriverCategory);
    }

    /**
     * @test update
     */
    public function testUpdatedriverCategory()
    {
        $driverCategory = $this->makedriverCategory();
        $fakedriverCategory = $this->fakedriverCategoryData();
        $updateddriverCategory = $this->driverCategoryRepo->update($fakedriverCategory, $driverCategory->id);
        $this->assertModelData($fakedriverCategory, $updateddriverCategory->toArray());
        $dbdriverCategory = $this->driverCategoryRepo->find($driverCategory->id);
        $this->assertModelData($fakedriverCategory, $dbdriverCategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletedriverCategory()
    {
        $driverCategory = $this->makedriverCategory();
        $resp = $this->driverCategoryRepo->delete($driverCategory->id);
        $this->assertTrue($resp);
        $this->assertNull(driverCategory::find($driverCategory->id), 'driverCategory should not exist in DB');
    }
}
