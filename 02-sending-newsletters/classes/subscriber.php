<?php
class Subscriber extends Mainclass implements ActiveRecord {
    protected $db;
    public $id;
    public $name;
    public $email;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Make new instance of class
     *
     * @param $db
     * @return Subscriber
     */
    public static function make($db)
    {
        return new Subscriber($db);
    }

    /**
     * Save as active record
     */
    public function save()
    {
        if ($this->id) {
            $sql = "UPDATE subscribers SET name = :name, email = :email WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("name", $this->name);
            $statement->bindParam("email", $this->email);
            $statement->bindParam("id", $this->id);
            $statement->execute();
        }
        else {
            $sql = "INSERT INTO subscribers (name, email) VALUES (:name, :email)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("name", $this->name);
            $statement->bindParam("email", $this->email);
            $statement->execute();

            $this->id = $this->db->lastInsertId();
        }
    }

    /**
     * Get subscriber by ID or active record
     *
     * @param $id
     * @return mixed
     */
    public function get($id = 0)
    {
        if (empty($id)) $id = $this->id;

        $sql = "SELECT *  FROM subscribers WHERE id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("id", $id);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Send newsletter to subscriber
     *
     * @param $newsletterId
     * @param int $subscriberId
     * @param array $params
     * @return string
     */
    public function send($newsletterId, $subscriberId = 0, $params = [])
    {
        if (empty($subscriberId)) $subscriberId = $this->id;

        // get newletter
        $newsletterObj = new Newsletter($this->db);
        $newsletter = $newsletterObj->get($newsletterId);

        // get user info
        $subscriber = $this->get($subscriberId);

        // for testing purposes we returning just HTML
        $html = "";

        $html .= "<div class='well well-sm'>";
        $html .= "<p><b>{$subscriber['name']}</b> &lt;{$subscriber['email']}&gt;</p>";
        $html .= "<p><b>Subject:</b> {$newsletter['subject']}</p>";
        $html .= "<br/>";
        $html .= "<p><i>{$newsletter['body']}</i></p>";

        // if some additional params were passed
        if (!empty($params)) {
            if (!empty($params['post'])) {
                $html .= "<div class='alert alert-warning'>";
                    $html .= "<p>Post details:</p>";
                    $html .= "<p><a href='#'>{$params['post']['title']}</a></p>";
                $html .= "</div>";
            }
        }
        $html .= "</div>";

        return $html;
    }
}