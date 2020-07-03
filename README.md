# Coding Challenge Setup
## Forking 
Please fork this repository and activate Github Actions in the "Actions" tab in your fork 
to make use of the built-in CI capabilities:

> Workflows don't run on forked repositories by default. You must enable GitHub Actions in the Actions tab of the forked repository.

Source: [GitHub Docs](https://docs.github.com/en/actions/reference/events-that-trigger-workflows#pull-request-events-for-forked-repositories)

## Setup
A docker setup is provided in the `.docker` folder following the structure defined 
[here](https://www.pascallandau.com/blog/structuring-the-docker-setup-for-php-projects/) 
and can be set up via `make` commands:

```
make docker-setup
```

Please verify that docker is running successfully via `docker ps`
```
$ docker ps
CONTAINER ID        IMAGE                        COMMAND                  CREATED             STATUS              PORTS                                NAMES
11e85f1fe115        coding-challenge/mysql       "docker-entrypoint.s…"   3 hours ago         Up 3 hours          33060/tcp, 0.0.0.0:33060->3306/tcp   coding-challenge_mysql_1
b37211637853        coding-challenge/workspace   "/bin/docker-entrypo…"   3 hours ago         Up 3 hours          0.0.0.0:2222->22/tcp                 coding-challenge_workspace_1
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
php artisan verify
Verifying database connection...
Connection successful! Found the following databases:
coding_challenge
information_schema
mysql
performance_schema
sys
testing

Writing verification file...
Done.
````

The `verify` make target will also create a verification file in the root of this repository.
Please make a new commit including this file and send a link to your repository to you recruiter. 
