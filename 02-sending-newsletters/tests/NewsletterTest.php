<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use PHPUnit\Framework\TestCase;

class NewsletterTests extends TestCase
{
    protected function setUp()
    {
        // init test db
        $this->db = init_db('test.db');
        prepare_db($this->db);
    }

    public function testCreateNewsletter()
    {
        $newsletter1 = new Newsletter($this->db);
        $newsletter1->type      = 'welcome';
        $newsletter1->subject   = 'subject';
        $newsletter1->body      = 'body';
        $newsletter1->schedule  = date("Y-m-d H:i:s");
        $newsletter1->save();

        $query = $this->db->query('select * from newsletters');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(1, count($results));
    }

    public function testAddEventToNewsletter()
    {
        $newsletter1 = new Newsletter($this->db);
        $newsletter1->type      = 'welcome';
        $newsletter1->subject   = 'subject';
        $newsletter1->body      = 'body';
        $newsletter1->schedule  = date("Y-m-d H:i:s");
        $newsletter1->save();

        $newsletter1->addEvent('test');

        $query = $this->db->query('select * from newsletters_events');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(1, count($results));
    }

    public function testGetEventFromNewsletter()
    {
        $newsletter1 = new Newsletter($this->db);
        $newsletter1->type      = 'welcome';
        $newsletter1->subject   = 'subject';
        $newsletter1->body      = 'body';
        $newsletter1->schedule  = date("Y-m-d H:i:s");
        $newsletter1->save();

        $newsletter1->addEvent('test1');
        $newsletter1->addEvent('test2');

        $events = $newsletter1->events($newsletter1->id);

        $query = $this->db->query('select * from newsletters_events');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(2, count($results));
    }

    public function testAddListingToNewsletter()
    {
        $newsletter1 = new Newsletter($this->db);
        $newsletter1->type      = 'welcome';
        $newsletter1->subject   = 'subject';
        $newsletter1->body      = 'body';
        $newsletter1->schedule  = date("Y-m-d H:i:s");
        $newsletter1->save();

        $listing1 = new Listing($this->db);
        $listing1->name = 'test';
        $listing1->save();

        $newsletter1->addListing($listing1);

        $query = $this->db->query('select * from newsletter_listing');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(1, count($results));
    }

    public function testSend()
    {
        // create newsletter
        $newsletter = new Newsletter($this->db);
        $newsletter->type      = 'news';
        $newsletter->subject   = 'test';
        $newsletter->body      = 'test';
        $newsletter->save();

        $listing1 = new Listing($this->db);
        $listing1->name = 'Family';
        $listing1->save();

        $subscriber = new Subscriber($this->db);
        $subscriber->name = 'Test';
        $subscriber->email = 'test@test.com';
        $subscriber->save();

        $listing1->subscribe($subscriber);

        $newsletter->addListing($listing1);

        $result = $newsletter->send();

        $this->assertEquals('Test &lt;test@test.com&gt;Subject: testtest', strip_tags($result));
    }

    protected function tearDown()
    {
        // DB clears itself before each launch
    }
}