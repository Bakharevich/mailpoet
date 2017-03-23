<?php
class Post extends Mainclass implements ActiveRecord {
    protected $db;
    public $id;
    public $title;
    public $content;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Save as active record
     */
    public function save()
    {
        if ($this->id) {
            $sql = "UPDATE posts SET title = :title, content = :conten WHERE id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("title", $this->title);
            $statement->bindParam("content", $this->content);
            $statement->execute();
        }
        else {
            $sql = "INSERT INTO posts (title, content) VALUES (:title, :content)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam("title", $this->title);
            $statement->bindParam("content", $this->content);
            $statement->execute();

            $this->id = $this->db->lastInsertId();
        }
    }

    /**
     * Get by ID or as active record
     *
     * @param int $id
     * @return mixed
     */
    public function get($id = 0)
    {
        if (empty($id)) $id = $this->id;

        $sql = "SELECT * FROM posts WHERE id = :id";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("id", $id);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Publish new post
     *
     * @param int $id
     * @return mixed
     */
    public function publish($id = 0)
    {
        if (empty($id)) $id = $this->id;

        $result = $this->fire('post_published', ['post_id' => $id]);

        return $result;
    }
}