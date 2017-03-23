<?php
require_once 'abstract/mainclass.php';
require_once 'interfaces/active_record.php';
require_once 'interfaces/event.php';
require_once 'classes/listing.php';
require_once 'classes/subscriber.php';
require_once 'classes/newsletter.php';
require_once 'classes/post.php';
require_once 'events/subscriber_added.php';
require_once 'events/post_published.php';


/* Init DB */
function init_db($name = 'sqlite.db') {
    $db = new PDO("sqlite:db/" . $name);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}

/* Prepare Database with tables and values for each execution */
function prepare_db($db) {
    $file = file_get_contents("fixtures/sqlite.sql");
    $arr = explode(";", $file);

    foreach ($arr as $line) {
        if (!empty($line)) {
            try {
                $db->exec($line);
            } catch (Exception $e) {
                echo $e . "<br/>";
            }
        }
    }
}