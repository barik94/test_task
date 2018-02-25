## Test task 

To start project clone repo by `git clone git@github.com:barik94/test_task.git`.

Next go to project folder `cd test_task`.

To get vendors let install composer and it so useful to set up it globally. Than make `composer install`.

Configure connection to MySql in `app/config/parameters.yml` and work with DB `php bin/console do:da:cr`, `php bin/console do:sc:cr`, `php bin/console do:sc:up --force`.

Start server with command `php bin/console server:run` and let work with routes:
 - `/` - index with all clicks
 - `/click/` - action click
 - `/success/{ID}` - successful redirect
 - `/error/{ID}` - error redirect after repeated click
