<?php

namespace CodingChallenge\Commands;

use Carbon\Carbon;
use Google\Cloud\BigQuery\BigQueryClient;
use Illuminate\Console\Command;
use PDO;

class VerifyCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'verify';

    /**
     * @var string
     */
    protected $description = 'Verifies that the application can run artisan commands';

    public function handle()
    {
        $verificationData = [
            Carbon::now()->format(Carbon::RFC3339),
            "",
        ];

        $this->info("Gathering PHP settings...");

        $verificationData[] = "PHP settings:";
        $verificationData[] = "==========";
        $verificationData[] = `php -i`;
        $verificationData[] = "";
        $this->info("Done.");

        $this->info("Verifying MySql database connection...");
        $result = [
            "failed",
        ];
        try {
            $pdo    = new PDO('mysql:dbname=coding_challenge;host=mysql;port=3306', 'root', 'root');
            $result = $pdo->query("SHOW DATABASES;")->fetchAll();
            $this->info("Connection successful!");
        } catch (\Throwable $t) {
            $this->error("Connection failed: " . $t->getMessage());
        }

        $verificationData[] = "MySql databases:";
        $verificationData[] = "==========";
        $verificationData[] = var_export($result, true);
        $verificationData[] = "";

        $this->info("Verifying BigQuery connection...");
        $result = [
            "failed",
        ];
        try {
            $client = new BigQueryClient([
                "keyFilePath" => base_path("google-cloud-key.json"),
            ]);
            $query  = $client->query("SELECT COUNT(*) as row_count FROM bigquery-public-data.google_analytics_sample.ga_sessions_20170801");
            $result = $client->runQuery($query);
            $result = iterator_to_array($result->getIterator());
            $this->info("Connection successful!");
        } catch (\Throwable $t) {
            $this->error("Connection failed: " . $t->getMessage());
        }

        $verificationData[] = "BigQuery query result:";
        $verificationData[] = "==========";
        $verificationData[] = var_export($result, true);
        $verificationData[] = "";

        $this->info("Writing verification file...");
        file_put_contents(base_path("verification"), implode("\n", $verificationData));
        $this->info("Done.");
    }
}
