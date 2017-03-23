<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<div class="container">

<?php
require_once 'bootstrap.php';

// init DB configuration
$db = init_db();
prepare_db($db);

/**
 * CREATE [WELCOME] NEWSLETTER
 */
$newsletter1 = new Newsletter($db);
$newsletter1->type      = 'welcome';
$newsletter1->subject   = 'welcome - You are subscribed';
$newsletter1->body      = 'Thank you for your subscription!';
$newsletter1->schedule  = date("Y-m-d H:i:s");
$newsletter1->save();

// add event to post newsletter if new user added
$newsletter1->addEvent('subscriber_added');

// create listing
$listing1 = new Listing($db);
$listing1->name = 'Family';
$listing1->save();

// add listing to newsletter
$newsletter1->addListing($listing1);

// create users
$subscriber1 = new Subscriber($db);
$subscriber1->name = 'Ilya';
$subscriber1->email = 'ilya@bakharevich.by';
$subscriber1->save();

$subscriber2 = new Subscriber($db);
$subscriber2->name = 'Yanina';
$subscriber2->email = 'yana_yushkevich@mail.ru';
$subscriber2->save();

// add users to listing 1
echo "<h3>2 users subscribed</h3>";

$res = $listing1->subscribe($subscriber1);
echo $res;
$res = $listing1->subscribe($subscriber2);
echo $res;



/**
 * CREATE [NOTIFICATION] NEWSLETTER
 */
$newsletter2 = new Newsletter($db);
$newsletter2->type      = 'notification';
$newsletter2->subject   = 'notification - New content has been published';
$newsletter2->body      = 'Hey! Don\'t miss new post!';
$newsletter2->save();

// add event to post newsletter if new user added
$newsletter2->addEvent('post_published');

// create listing
$listing2 = new Listing($db);
$listing2->name = 'Public Users';
$listing2->save();

// add listing to newsletter
$newsletter2->addListing($listing2);

// create users
$subscriber3 = new Subscriber($db);
$subscriber3->name = 'Steve Jobs';
$subscriber3->email = 'stevey@apple.com';
$subscriber3->save();

$subscriber4 = new Subscriber($db);
$subscriber4->name = 'Bill Gates';
$subscriber4->email = 'billy@microsoft.com';
$subscriber4->save();

// add users to listings
$listing2->subscribe($subscriber3);
$listing2->subscribe($subscriber4);

// need to create new post
$post = new Post($db);
$post->title = 'Post title';
$post->content = 'Post content';
$post->save();

// and publish it (to create new event)
echo "<h3>New post has been published</h3>";
$result = $post->publish();
echo $result;



/**
 * CREATE [NEWS] NEWSLETTER
 */
// create newsletter
$newsletter3 = new Newsletter($db);
$newsletter3->type      = 'news';
$newsletter3->subject   = 'news - Just common newsletter for several listings';
$newsletter3->body      = 'Just posted ';
$newsletter3->save();

// add existing listings
$newsletter3->addListing($listing1);
$newsletter3->addListing($listing2);

// send it
echo "<h3>Common news newsletter has been sent</h3>";
$result = $newsletter3->send();

echo $result;
?>