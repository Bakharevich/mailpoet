<?php
class post_published implements Event  {
    public function fire($params) {
        $db = init_db();

        $postObj = new Post($db);
        $newsletterObj = new Newsletter($db);
        $listingObj = new Listing($db);
        $subscriberObj = new Subscriber($db);

        // get post
        $post = $postObj->get($params['post_id']);

        // get newsletters which has "publish_post" event
        $newsletters = $newsletterObj->getByEvent('post_published');

        $result = '';

        // for every newsletter get listing
        foreach ($newsletters as $newsletter) {
            $listings = $newsletterObj->listings($newsletter['id']);

            // for every listing get it's subscribers
            foreach ($listings as $listing) {
                $subscribers = $listingObj->subscribers($listing['id']);

                // send to every subscriber
                foreach ($subscribers as $subscriber) {
                    $result .= $subscriberObj->send(
                        $newsletter['id'],
                        $subscriber['id'],
                        [
                            'post' => ['title' => $post['title']]
                        ]
                    );
                }
            }
        }

        return $result;
    }
}