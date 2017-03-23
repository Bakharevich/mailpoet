<?php
class Newsletter extends Mainclass implements ActiveRecord {
    protected $db;
    public $id;
    public $type;
    public $subject;
    public $body;
    public $schedule;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Save
     */
    public function save()
    {
        if ($this->id) {
            $sql = "UPDATE newsletters SET type = :type, subject = :subject, body = :body, schedule = :schedule WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("type", $this->type);
            $statement->bindParam("subject", $this->subject);
            $statement->bindParam("body", $this->body);
            $statement->bindParam("schedule", $this->schedule);
            $statement->bindParam("id", $this->id);
            $statement->execute();
        }
        else {
            $sql = "INSERT INTO newsletters (type, subject, body, schedule) VALUES (:type, :subject, :body, :schedule)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("type", $this->type);
            $statement->bindParam("subject", $this->subject);
            $statement->bindParam("body", $this->body);
            $statement->bindParam("schedule", $this->schedule);
            $statement->execute();

            $this->id = $this->db->lastInsertId();
        }
    }

    /**
     * Get newsletter
     *
     * @param int $id
     * @return mixed
     */
    public function get($id = 0)
    {
        if (empty($id)) $id = $this->id;

        $sql = "SELECT * FROM newsletters WHERE id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("id", $id);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Send newletter to all subscribed listings
     *
     * @param int $newsletterId
     * @return string
     */
    public function send($newsletterId = 0)
    {
        if (empty($newsletterId)) $newsletterId = $this->id;

        $result = '';

        $listingObj = new Listing($this->db);

        // get all listings for that newsletter
        $listings = $this->listings($newsletterId);

        // get subscribers for each listing
        foreach ($listings as $listing) {
            $subscribers = Listing::make($this->db)->subscribers($listing['id']);

            foreach ($subscribers as $subscriber) {
                $result .= Subscriber::make($this->db)->send($newsletterId, $subscriber['id']);
            }
        }

        return $result;
    }

    /**
     * Add new listing to newsletter
     *
     * @param Listing $listing
     */
    public function addListing(Listing $listing)
    {
        $sql = "INSERT INTO newsletter_listing (newsletter_id, listing_id) VALUES (:newsletter_id, :listing_id)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("newsletter_id", $this->id);
        $statement->bindParam("listing_id", $listing->id);
        $statement->execute();
    }

    /**
     * Add new event to newsletter
     *
     * @param $name
     */
    public function addEvent($name)
    {
        $sql = "INSERT INTO newsletters_events (newsletter_id, name) VALUES (:newsletter_id, :name)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("newsletter_id", $this->id);
        $statement->bindParam("name", $name);
        $statement->execute();
    }

    /**
     * Get all newsletter events
     *
     * @param $newsletterId
     * @return mixed
     */
    public function events($newsletterId)
    {
        $sql = "SELECT * FROM newsletters_events WHERE newsletter_id = :newsletter_id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("newsletter_id", $newsletterId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Get all newsletter listings (MANY-TO-MANY)
     *
     * @param $newsletterId
     * @return mixed
     */
    public function listings($newsletterId)
    {
        if (empty($newsletterId)) $newsletterId = $this->id;

        $sql = "SELECT l.*
                FROM newsletter_listing nl
                LEFT JOIN listings l ON nl.listing_id = l.id 
                WHERE nl.newsletter_id = :newsletter_id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("newsletter_id", $newsletterId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Get newsletter's event by event name
     *
     * @param $name
     * @return mixed
     */
    public function getByEvent($name)
    {
        $sql = "SELECT n.*
                FROM newsletters_events ne
                LEFT JOIN newsletters n ON ne.newsletter_id = n.id 
                WHERE ne.name = :name";

        $statement = $this->db->prepare($sql);
        $statement->bindParam("name", $name);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}