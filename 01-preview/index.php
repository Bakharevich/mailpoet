<?php
require_once 'db.php';
require_once 'view.php';
require_once 'config.php';

// get ID param, to INT
$id = (int) $_GET['id'];

// init DB
$DB = new DB(HOST, USERNAME, PASSWORD, NAME);

$newsletter = $DB->assoc("SELECT id, subject, body FROM wp_mailpoet_newsletters WHERE id=" . $id);

if (empty($newsletter)) {
    echo View::error("There is no newsletter with ID {$id}", 404);
    exit();
}

echo View::preview($newsletter);