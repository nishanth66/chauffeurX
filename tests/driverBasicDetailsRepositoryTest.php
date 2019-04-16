<?php

use App\Models\driverBasicDetails;
use App\Repositories\driverBasicDetailsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class driverBasicDetailsRepositoryTest extends TestCase
{
    use MakedriverBasicDetailsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var driverBasicDetailsRepository
     */
    protected $driverBasicDetailsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->driverBasicDetailsRepo = App::make(driverBasicDetailsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatedriverBasicDetails()
    {
        $driverBasicDetails = $this->fakedriverBasicDetailsData();
        $createddriverBasicDetails = $this->driverBasicDetailsRepo->create($driverBasicDetails);
        $createddriverBasicDetails = $createddriverBasicDetails->toArray();
        $this->assertArrayHasKey('id', $createddriverBasicDetails);
        $this->assertNotNull($createddriverBasicDetails['id'], 'Created driverBasicDetails must have id specified');
        $this->assertNotNull(driverBasicDetails::find($createddriverBasicDetails['id']), 'driverBasicDetails with given id must be in DB');
        $this->assertModelData($driverBasicDetails, $createddriverBasicDetails);
    }

    /**
     * @test read
     */
    public function testReaddriverBasicDetails()
    {
        $driverBasicDetails = $this->makedriverBasicDetails();
        $dbdriverBasicDetails = $this->driverBasicDetailsRepo->find($driverBasicDetails->id);
        $dbdriverBasicDetails = $dbdriverBasicDetails->toArray();
        $this->assertModelData($driverBasicDetails->toArray(), $dbdriverBasicDetails);
    }

    /**
     * @test update
     */
    public function testUpdatedriverBasicDetails()
    {
        $driverBasicDetails = $this->makedriverBasicDetails();
        $fakedriverBasicDetails = $this->fakedriverBasicDetailsData();
        $updateddriverBasicDetails = $this->driverBasicDetailsRepo->update($fakedriverBasicDetails, $driverBasicDetails->id);
        $this->assertModelData($fakedriverBasicDetails, $updateddriverBasicDetails->toArray());
        $dbdriverBasicDetails = $this->driverBasicDetailsRepo->find($driverBasicDetails->id);
        $this->assertModelData($fakedriverBasicDetails, $dbdriverBasicDetails->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletedriverBasicDetails()
    {
        $driverBasicDetails = $this->makedriverBasicDetails();
        $resp = $this->driverBasicDetailsRepo->delete($driverBasicDetails->id);
        $this->assertTrue($resp);
        $this->assertNull(driverBasicDetails::find($driverBasicDetails->id), 'driverBasicDetails should not exist in DB');
    }
}
