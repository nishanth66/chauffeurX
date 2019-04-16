<?php

use App\Models\driverVerification;
use App\Repositories\driverVerificationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class driverVerificationRepositoryTest extends TestCase
{
    use MakedriverVerificationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var driverVerificationRepository
     */
    protected $driverVerificationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->driverVerificationRepo = App::make(driverVerificationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatedriverVerification()
    {
        $driverVerification = $this->fakedriverVerificationData();
        $createddriverVerification = $this->driverVerificationRepo->create($driverVerification);
        $createddriverVerification = $createddriverVerification->toArray();
        $this->assertArrayHasKey('id', $createddriverVerification);
        $this->assertNotNull($createddriverVerification['id'], 'Created driverVerification must have id specified');
        $this->assertNotNull(driverVerification::find($createddriverVerification['id']), 'driverVerification with given id must be in DB');
        $this->assertModelData($driverVerification, $createddriverVerification);
    }

    /**
     * @test read
     */
    public function testReaddriverVerification()
    {
        $driverVerification = $this->makedriverVerification();
        $dbdriverVerification = $this->driverVerificationRepo->find($driverVerification->id);
        $dbdriverVerification = $dbdriverVerification->toArray();
        $this->assertModelData($driverVerification->toArray(), $dbdriverVerification);
    }

    /**
     * @test update
     */
    public function testUpdatedriverVerification()
    {
        $driverVerification = $this->makedriverVerification();
        $fakedriverVerification = $this->fakedriverVerificationData();
        $updateddriverVerification = $this->driverVerificationRepo->update($fakedriverVerification, $driverVerification->id);
        $this->assertModelData($fakedriverVerification, $updateddriverVerification->toArray());
        $dbdriverVerification = $this->driverVerificationRepo->find($driverVerification->id);
        $this->assertModelData($fakedriverVerification, $dbdriverVerification->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletedriverVerification()
    {
        $driverVerification = $this->makedriverVerification();
        $resp = $this->driverVerificationRepo->delete($driverVerification->id);
        $this->assertTrue($resp);
        $this->assertNull(driverVerification::find($driverVerification->id), 'driverVerification should not exist in DB');
    }
}
