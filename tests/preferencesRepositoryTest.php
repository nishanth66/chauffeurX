<?php

use App\Models\preferences;
use App\Repositories\preferencesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class preferencesRepositoryTest extends TestCase
{
    use MakepreferencesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var preferencesRepository
     */
    protected $preferencesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->preferencesRepo = App::make(preferencesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatepreferences()
    {
        $preferences = $this->fakepreferencesData();
        $createdpreferences = $this->preferencesRepo->create($preferences);
        $createdpreferences = $createdpreferences->toArray();
        $this->assertArrayHasKey('id', $createdpreferences);
        $this->assertNotNull($createdpreferences['id'], 'Created preferences must have id specified');
        $this->assertNotNull(preferences::find($createdpreferences['id']), 'preferences with given id must be in DB');
        $this->assertModelData($preferences, $createdpreferences);
    }

    /**
     * @test read
     */
    public function testReadpreferences()
    {
        $preferences = $this->makepreferences();
        $dbpreferences = $this->preferencesRepo->find($preferences->id);
        $dbpreferences = $dbpreferences->toArray();
        $this->assertModelData($preferences->toArray(), $dbpreferences);
    }

    /**
     * @test update
     */
    public function testUpdatepreferences()
    {
        $preferences = $this->makepreferences();
        $fakepreferences = $this->fakepreferencesData();
        $updatedpreferences = $this->preferencesRepo->update($fakepreferences, $preferences->id);
        $this->assertModelData($fakepreferences, $updatedpreferences->toArray());
        $dbpreferences = $this->preferencesRepo->find($preferences->id);
        $this->assertModelData($fakepreferences, $dbpreferences->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletepreferences()
    {
        $preferences = $this->makepreferences();
        $resp = $this->preferencesRepo->delete($preferences->id);
        $this->assertTrue($resp);
        $this->assertNull(preferences::find($preferences->id), 'preferences should not exist in DB');
    }
}
