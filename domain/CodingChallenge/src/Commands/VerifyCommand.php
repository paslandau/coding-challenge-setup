<?php

namespace CodingChallenge\Commands;

use Carbon\Carbon;
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
        $this->info("Verifying database connection...");
        $pdo    = new PDO('mysql:dbname=coding_challenge;host=mysql;port=3306', 'root', 'root');
        $result = $pdo->query("SHOW DATABASES;")->fetchAll();
        $this->info("Connection successful! Found the following databases:");
        $this->line(implode("\n", array_column($result, 0)) . "\n");

        $this->info("Writing verification file...");
        $verification = `php -i` . "\n\n" . Carbon::now()->format(\DateTimeInterface::RFC3339);
        file_put_contents(base_path("verification"), $verification);
        $this->info("Done.");
    }
}
