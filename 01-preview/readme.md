# 1) Code review for preview

## Security issues:

- make ID safe - convert ID to INTEGER

- $_SERVER['PHP_SELF'] is unsafe, as it's vulnerable for XSS (Cross Site Scripting). We need to make it safe by htmlentities()


## Optimization issues:

- update 'SELECT *' to 'SELECT subject, body' as we need only some specific columns to show preview

- remove single quotes near ID, as we're sure that it's integer value

- we're taking only one row by primary key ID, so loop seems to be not needed?

- I've created separate View class, which is responsible for showing HTML.  If we will need to show preview in another place/send it at email/just update it, we can do it just in one class. Also In future we can improve it by templates, translations, caching, e.t.c. So, we have all work in one place and it's easy to maintain.


## Infrastructure issues:

- mysql_* functions are deprecated in PHP 5.5.0. If script is executed at fresh server, it won't work (in PHP 7 mysql_* functions were removed). I've added separate DB class which is responsible for selecting appropriate functions

- it's better to move DB config to one single place. So if user/password/db name will change, we should not replace it in every file.


I'm not sure, if you need more complex or simple solution. May be it was kind of overhead with all classes and preview?