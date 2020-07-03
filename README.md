# Coding Challenge Setup
You need at least PHP 7.4 with Composer, an IDE like PhpStorm and a MySQL database.

A docker setup is provided in the `.docker` folder following the structure defined 
[here](https://www.pascallandau.com/blog/structuring-the-docker-setup-for-php-projects/) 
and can be set up via `make` commands:

```
make docker-setup
```

Once docker is running, the application can be setup via `make` commands as well:

```
make setup
```

IDE integration with PhpStorm is described 
[here](https://www.pascallandau.com/blog/setup-phpstorm-with-xdebug-on-docker/) for reference.

## Task
Please make sure you can successfully set up the infrastructure. You can "verfiy" the setup via
`make verify` and should see the following output:

````
$ make verify
..................... 21 / 21 (100%)


Time: 710ms; Memory: 6MB

PHPUnit 9.2.5 by Sebastian Bergmann and contributors.

...                                                                 3 / 3 (100%)

Time: 00:00.574, Memory: 16.00 MB

OK (3 tests, 3 assertions)
Verifying database connection...
Connection successful! Found the following databases:
coding_challenge
information_schema
mysql
performance_schema
sys
testing
````

Changes
