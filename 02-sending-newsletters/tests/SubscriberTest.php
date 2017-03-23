<?php
use PHPUnit\Framework\TestCase;

class SubscriberTests extends TestCase
{
    protected function setUp()
    {
        // init test db
        $this->db = init_db('test.db');
        prepare_db($this->db);
    }

    public function testCreateSubcriber()
    {
        $subscriber1 = new Subscriber($this->db);
        $subscriber1->name = 'test';
        $subscriber1->email = 'test@test.com';
        $subscriber1->save();

        $query = $this->db->query('select * from subscribers');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);

        $this->assertEquals(1, count($results));
    }

    public function testSubscriberSend()
    {
        // subscriber
        $subscriber1 = new Subscriber($this->db);
        $subscriber1->name = 'test';
        $subscriber1->email = 'test@test.com';
        $subscriber1->save();

        // newsletter
        $newsletter3 = new Newsletter($this->db);
        $newsletter3->type      = 'news';
        $newsletter3->subject   = 'test';
        $newsletter3->body      = 'test';
        $newsletter3->save();

        $result = $subscriber1->send($newsletter3->id, $subscriber1->id);

        $this->assertEquals("test &lt;test@test.com&gt;Subject: testtest", strip_tags($result));
    }

    protected function tearDown()
    {
        // DB clears itself before each launch
    }
}