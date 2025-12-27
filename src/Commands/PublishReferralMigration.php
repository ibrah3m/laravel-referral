<?php

namespace Ibrah3m\LaravelReferral\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishReferralMigration extends Command
{
    protected $signature = 'referral:publish-migration';
    protected $description = 'Publish the referral migration with current timestamp';

    public function handle(): int
    {
        $stubPath = __DIR__ . '/../../database/migrations/create_referrals_table.php.stub';
        $migrationsPath = database_path('migrations');
        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_create_referrals_table.php";
        $destinationPath = $migrationsPath . '/' . $filename;

        if (File::exists($destinationPath)) {
            $this->warn("Migration file already exists: {$filename}");
            return Command::SUCCESS;
        }

        File::copy($stubPath, $destinationPath);
        $this->info("Migration published successfully: {$filename}");

        return Command::SUCCESS;
    }
}
