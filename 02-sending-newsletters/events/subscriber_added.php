<?php
class subscriber_added implements Event {
    public function fire($params)
    {
        $db = init_db();

        $listing    = new Listing($db);
        $subscriberObj = new Subscriber($db);
        $newsletterObj = new Newsletter($db);

        // get subscriber
        $subscriber = $subscriberObj->get($params['subscriber_id']);

        // get all newsletters which listing has
        $newsletters = $listing->newsletters($params['listing_id']);

        $result = '';

        // iterate newsletters
        foreach ($newsletters as $news) {
            // get events for every newsletter
            $events = $newsletterObj->events($news['id']);

            // iterate events. if event is "send_if_new", send that newsletter to user
            foreach ($events as $event) {
                if ($event['name'] == "subscriber_added") {
                    $result .= $subscriberObj->send($news['id'], $subscriber['id']);
                }
            }
        }

        return $result;
    }
}