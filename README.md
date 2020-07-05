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
[here](https://www.pascallandau.com/blog/setup-phpstorm-with-xdebug-on-docker/) for reference. Please note, that we're using password based authentication 
instead of an (insecure) private key file. The password can be specified via `WORKSPACE_SSH_PASSWORD=123456` in the`.docker/.env` file _before_ building the containers.

## BigQuery key file
[BigQuery](https://cloud.google.com/bigquery/) is a central component in our infrastructure. 
The [BigQuery SDK](https://packagist.org/packages/google/cloud-bigquery) is already included in the
dependencies of this project, but you will need to create a service account with a corresponding 
credential file and add it to this repository in order to complete the setup task. See the official 
[authentication instructions](https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md) for more details.

**Note**: We recommend the usage of a `.json` key file as described 
[in this tutorial on Service Account based Authentication](https://www.progress.com/tutorials/odbc/a-complete-guide-for-google-bigquery-authentication#service-account-based-authentication)

Please make sure to name the file `google-cloud-key.json` and put it in the root of the repository. It should look likes this:

````
{
  "type": "service_account",
  "project_id": "<your-project>",
  "private_key_id": "3a88f2...66c18120",
  "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvgIBA...bMq+ktxb\n-----END PRIVATE KEY-----\n",
  "client_email": "coding-challenge@<your-project>.iam.gserviceaccount.com",
  "client_id": "1127...3003",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/coding-challenge%40<your-project>.iam.gserviceaccount.com"
}
````

`google-cloud-key.json` is ignored via `.gitignore`.

## Task
Please "verfiy" the setup via `make verify`. You should see the following output:

````
$ make verify
vendor/bin/phpcs -p -n --standard=PSR12 app/ domain/
.................... 20 / 20 (100%)


Time: 522ms; Memory: 8MB

vendor/bin/phpunit -c phpunit.xml
PHPUnit 9.2.5 by Sebastian Bergmann and contributors.

...                                                                 3 / 3 (100%)

Time: 00:00.522, Memory: 20.00 MB

OK (3 tests, 3 assertions)
php artisan verify
Gathering PHP settings...
Done.
Verifying MySql database connection...
Connection successful!
Verifying BigQuery connection...
Connection successful!
Writing verification file...
Done.
````

The `verify` make target will also create a verification file in the root of this repository.

Please add a new commit including the verification file, push it to your repository and send a link to the fork to the recruiter. 
