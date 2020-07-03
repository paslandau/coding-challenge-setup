<?php

namespace Tests\Feature;

use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Schema\Blueprint;
use PDOException;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureDatabaseExists();
    }

    protected function ensureDatabaseExists(): void
    {
        $connection = $this->getMysqlConnection();

        try {
            $connection->getPdo();
        } catch (PDOException $e) {
            // e.g. SQLSTATE[HY000] [1049] Unknown database 'testing'
            if ($e->getCode() !== 1049) {
                throw $e;
            }
            $config             = $connection->getConfig();
            $config["database"] = "";

            $connector = new MySqlConnector();
            $pdo       = $connector->connect($config);
            $database  = $connection->getDatabaseName();
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}`;");
        }
    }

    protected function getMysqlConnection(): MySqlConnection
    {
        /**
         * @var DatabaseManager $dbManager
         */
        $dbManager = $this->app->make("db");

        /**
         * @var MySqlConnection $connection
         */
        $connection = $dbManager->connection();

        return $connection;
    }

    public function test_database_connection_works(): void
    {

        $tableName = "test_table";

        $connection = $this->getMysqlConnection();

        $schema = $connection->getSchemaBuilder();

        $schema->dropIfExists($tableName);

        $schema->create(
            "test_table",
            function (Blueprint $table): void {
                $table->integer("id");
                $table->primary("id");
            }
        );

        $connection
            ->table($tableName)
            ->insert([
                "id" => 1337,
            ])
        ;

        $expected = [
            [
                "id" => 1337,
            ],
        ];

        $actual = $connection
            ->table($tableName)
            ->get()
            ->map(fn($item) => (array) $item)
            ->all()
        ;

        $this->assertEquals($expected, $actual);
    }
}
