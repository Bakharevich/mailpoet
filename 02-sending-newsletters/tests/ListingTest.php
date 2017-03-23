<?php
use PHPUnit\Framework\TestCase;

class ListingTests extends TestCase
{
    protected function setUp()
    {
        // init test db
        $this->db = init_db('test.db');
        prepare_db($this->db);
    }

    public function testCreateListing()
    {
        $listing2 = new Listing($this->db);
        $listing2->name = 'test';
        $listing2->save();

        $query = $this->db->query('select * from listings');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(1, count($results));
    }

    public function testListingSubscribe()
    {
        $listing = new Listing($this->db);
        $listing->name = 'test';
        $listing->save();

        $subscriber = new Subscriber($this->db);
        $subscriber->name = 'test';
        $subscriber->email = 'test@test.com';
        $subscriber->save();

        $listing->subscribe($subscriber);

        $query = $this->db->query('select * from listing_subscriber');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(1, count($results));
    }

    public function testGetListingFunctionSubscribers()
    {
        $listing = new Listing($this->db);
        $listing->name = 'test';
        $listing->save();

        $subscriber = new Subscriber($this->db);
        $subscriber->name = 'test';
        $subscriber->email = 'test@test.com';
        $subscriber->save();

        $subscriber2 = new Subscriber($this->db);
        $subscriber2->name = 'test';
        $subscriber2->email = 'test@test.com';
        $subscriber2->save();

        $listing->subscribe($subscriber);
        $listing->subscribe($subscriber2);

        $listing->subscribers();

        $query = $this->db->query('select * from listing_subscriber');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(2, count($results));
    }

    protected function tearDown()
    {
        // DB clears itself before each launch
    }
}