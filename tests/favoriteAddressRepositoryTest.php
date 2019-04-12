<?php

use App\Models\favoriteAddress;
use App\Repositories\favoriteAddressRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class favoriteAddressRepositoryTest extends TestCase
{
    use MakefavoriteAddressTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var favoriteAddressRepository
     */
    protected $favoriteAddressRepo;

    public function setUp()
    {
        parent::setUp();
        $this->favoriteAddressRepo = App::make(favoriteAddressRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatefavoriteAddress()
    {
        $favoriteAddress = $this->fakefavoriteAddressData();
        $createdfavoriteAddress = $this->favoriteAddressRepo->create($favoriteAddress);
        $createdfavoriteAddress = $createdfavoriteAddress->toArray();
        $this->assertArrayHasKey('id', $createdfavoriteAddress);
        $this->assertNotNull($createdfavoriteAddress['id'], 'Created favoriteAddress must have id specified');
        $this->assertNotNull(favoriteAddress::find($createdfavoriteAddress['id']), 'favoriteAddress with given id must be in DB');
        $this->assertModelData($favoriteAddress, $createdfavoriteAddress);
    }

    /**
     * @test read
     */
    public function testReadfavoriteAddress()
    {
        $favoriteAddress = $this->makefavoriteAddress();
        $dbfavoriteAddress = $this->favoriteAddressRepo->find($favoriteAddress->id);
        $dbfavoriteAddress = $dbfavoriteAddress->toArray();
        $this->assertModelData($favoriteAddress->toArray(), $dbfavoriteAddress);
    }

    /**
     * @test update
     */
    public function testUpdatefavoriteAddress()
    {
        $favoriteAddress = $this->makefavoriteAddress();
        $fakefavoriteAddress = $this->fakefavoriteAddressData();
        $updatedfavoriteAddress = $this->favoriteAddressRepo->update($fakefavoriteAddress, $favoriteAddress->id);
        $this->assertModelData($fakefavoriteAddress, $updatedfavoriteAddress->toArray());
        $dbfavoriteAddress = $this->favoriteAddressRepo->find($favoriteAddress->id);
        $this->assertModelData($fakefavoriteAddress, $dbfavoriteAddress->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletefavoriteAddress()
    {
        $favoriteAddress = $this->makefavoriteAddress();
        $resp = $this->favoriteAddressRepo->delete($favoriteAddress->id);
        $this->assertTrue($resp);
        $this->assertNull(favoriteAddress::find($favoriteAddress->id), 'favoriteAddress should not exist in DB');
    }
}
