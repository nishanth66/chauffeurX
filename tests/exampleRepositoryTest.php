<?php

use App\Models\example;
use App\Repositories\exampleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class exampleRepositoryTest extends TestCase
{
    use MakeexampleTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var exampleRepository
     */
    protected $exampleRepo;

    public function setUp()
    {
        parent::setUp();
        $this->exampleRepo = App::make(exampleRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateexample()
    {
        $example = $this->fakeexampleData();
        $createdexample = $this->exampleRepo->create($example);
        $createdexample = $createdexample->toArray();
        $this->assertArrayHasKey('id', $createdexample);
        $this->assertNotNull($createdexample['id'], 'Created example must have id specified');
        $this->assertNotNull(example::find($createdexample['id']), 'example with given id must be in DB');
        $this->assertModelData($example, $createdexample);
    }

    /**
     * @test read
     */
    public function testReadexample()
    {
        $example = $this->makeexample();
        $dbexample = $this->exampleRepo->find($example->id);
        $dbexample = $dbexample->toArray();
        $this->assertModelData($example->toArray(), $dbexample);
    }

    /**
     * @test update
     */
    public function testUpdateexample()
    {
        $example = $this->makeexample();
        $fakeexample = $this->fakeexampleData();
        $updatedexample = $this->exampleRepo->update($fakeexample, $example->id);
        $this->assertModelData($fakeexample, $updatedexample->toArray());
        $dbexample = $this->exampleRepo->find($example->id);
        $this->assertModelData($fakeexample, $dbexample->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteexample()
    {
        $example = $this->makeexample();
        $resp = $this->exampleRepo->delete($example->id);
        $this->assertTrue($resp);
        $this->assertNull(example::find($example->id), 'example should not exist in DB');
    }
}
