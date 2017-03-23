<?php
class Listing extends Mainclass implements ActiveRecord {
    protected $db;
    public $id;
    public $name;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Make object of class
     *
     * @param $db
     * @return Listing
     */
    public static function make($db)
    {
        return new Listing($db);
    }

    /**
     * Save in DB
     */
    public function save()
    {
        if ($this->id) {
            $sql = "UPDATE listings SET name = :name WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("name", $this->name);
            $statement->bindParam("id", $this->id);
            $statement->execute();
        }
        else {
            $sql = "INSERT INTO listings (name) VALUES (:name)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("name", $this->name);
            $statement->execute();

            $this->id = $this->db->lastInsertId();
        }
    }

    /**
     * Subscribes new subscriber for subscription
     *
     * @param Subscriber $subscriber
     * @return mixed
     */
    public function subscribe(Subscriber $subscriber)
    {
        $sql = "INSERT INTO listing_subscriber (listing_id, subscriber_id) VALUES (:listing_id, :subscriber_id)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("listing_id", $this->id);
        $statement->bindParam("subscriber_id", $subscriber->id);
        $statement->execute();

        // call event
        $result = $this->fire('subscriber_added', ['listing_id' => $this->id, 'subscriber_id' => $subscriber->id]);

        return $result;
    }

    /**
     * Get all listing's subscribets (MANY-TO-MANY)
     *
     * @param string $listingId
     * @return mixed
     */
    public function subscribers($listingId = '')
    {
        if (empty($listingId)) $listingId = $this->id;

        $sql = "SELECT s.*
                FROM listing_subscriber ls
                LEFT JOIN subscribers s ON ls.subscriber_id = s.id 
                WHERE ls.listing_id = :listing_id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("listing_id", $listingId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Get all newsletters (MANY-TO-MANY)
     *
     * @param string $listingId
     * @return mixed
     */
    public function newsletters($listingId = '')
    {
        if (empty($listingId)) $listingId = $this->id;

        $sql = "SELECT n.*
                FROM newsletter_listing nl
                LEFT JOIN newsletters n ON nl.newsletter_id = n.id 
                WHERE nl.listing_id = :listing_id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("listing_id", $listingId);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}