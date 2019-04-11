<?php

use App\Models\emergencyContacts;
use App\Repositories\emergencyContactsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class emergencyContactsRepositoryTest extends TestCase
{
    use MakeemergencyContactsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var emergencyContactsRepository
     */
    protected $emergencyContactsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->emergencyContactsRepo = App::make(emergencyContactsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateemergencyContacts()
    {
        $emergencyContacts = $this->fakeemergencyContactsData();
        $createdemergencyContacts = $this->emergencyContactsRepo->create($emergencyContacts);
        $createdemergencyContacts = $createdemergencyContacts->toArray();
        $this->assertArrayHasKey('id', $createdemergencyContacts);
        $this->assertNotNull($createdemergencyContacts['id'], 'Created emergencyContacts must have id specified');
        $this->assertNotNull(emergencyContacts::find($createdemergencyContacts['id']), 'emergencyContacts with given id must be in DB');
        $this->assertModelData($emergencyContacts, $createdemergencyContacts);
    }

    /**
     * @test read
     */
    public function testReademergencyContacts()
    {
        $emergencyContacts = $this->makeemergencyContacts();
        $dbemergencyContacts = $this->emergencyContactsRepo->find($emergencyContacts->id);
        $dbemergencyContacts = $dbemergencyContacts->toArray();
        $this->assertModelData($emergencyContacts->toArray(), $dbemergencyContacts);
    }

    /**
     * @test update
     */
    public function testUpdateemergencyContacts()
    {
        $emergencyContacts = $this->makeemergencyContacts();
        $fakeemergencyContacts = $this->fakeemergencyContactsData();
        $updatedemergencyContacts = $this->emergencyContactsRepo->update($fakeemergencyContacts, $emergencyContacts->id);
        $this->assertModelData($fakeemergencyContacts, $updatedemergencyContacts->toArray());
        $dbemergencyContacts = $this->emergencyContactsRepo->find($emergencyContacts->id);
        $this->assertModelData($fakeemergencyContacts, $dbemergencyContacts->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteemergencyContacts()
    {
        $emergencyContacts = $this->makeemergencyContacts();
        $resp = $this->emergencyContactsRepo->delete($emergencyContacts->id);
        $this->assertTrue($resp);
        $this->assertNull(emergencyContacts::find($emergencyContacts->id), 'emergencyContacts should not exist in DB');
    }
}
