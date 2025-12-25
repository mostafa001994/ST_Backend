<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup {--compress : Compress backup with gzip}';
    protected $description = 'Backup the database to storage/backups';

    public function handle()
    {
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');
        $port = env('DB_PORT', '3306');

        $timestamp = date('Ymd_His');
        $backupDir = storage_path('backups');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename = "{$backupDir}/{$db}_{$timestamp}.sql";
        if ($this->option('compress')) {
            $filename .= '.gz';
            $cmd = "mysqldump -u{$user} -p'{$pass}' -h{$host} -P{$port} {$db} | gzip > {$filename}";
        } else {
            $cmd = "mysqldump -u{$user} -p'{$pass}' -h{$host} -P{$port} {$db} > {$filename}";
        }

        $this->info("Running backup command...");
        exec($cmd, $output, $status);

        if ($status === 0) {
            $this->info("Backup created: {$filename}");
        } else {
            $this->error("Backup failed. Check credentials or mysqldump availability.");
        }
    }
}
