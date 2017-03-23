# 2) Sending newsletters

My idea was to create three type of newsletters: 

```
- Basic Newsletter
- Welcome Newsletter
- Notification Newletter.
```

MySQL tables:

```
listings
listings_subscriber (many-to-many relationship)
newsletters
newsletters_events
newsletter_listing (many-to-many relationship)
posts
subscribers
```

But in fact, each newsletter supports events. So, for example, you can add event "subscriber_added" event to Basic Newletter. And if somebody subscribe for it, it will also get that newletter. The same with "post_published" event. Create new event is pretty straight-forward - just create new class with interface "Event".  So, events makes it a bit flexible and removes some limitation.

All done in plain PHP, I've added some integrational tests using PHPUnit. Also it uses SQLite as database and Bootstrap just for some styles.

## Installation

Select directory:
``` bash
cd 02-sending-newsletters
```

Make directory with DB writable:
``` bash
chmod 777 db/
```

First install PHPUnit via Composer (if you don’t have Composer, you need to [install it first](https://getcomposer.org/doc/00-intro.md) ):
``` bash
composer install
```

Then check if everything is OK:
``` bash
phpunit
```

Then you can open that directory 02-sending-newsletters in browser (file index.php does all the job).

If you have any question, I will be glad to answer.