<?php

namespace App\Commands;

use App\Helpers\CertificateFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Spatie\SslCertificate\SslCertificate;

class CheckSingleFileCommand extends Command
{
    protected $signature = 'certificate:check
                            {file : the certificate file (required)}
                            ';

    protected $description = 'Get validity of a single certificate';

    public function handle(): mixed
    {
        $file = $this->argument('file');
        $this->info("");

        if (!File::isFile($file)) {
            $this->error("$file is NOT a valid file");
            return 1;
        }

        if (!CertificateFile::isPublicCertificate($file)) {
            $this->error("$file is NOT a valid file");
            return 1;
        }


        try {
            $certificate = SslCertificate::createFromFile($file);
            $this->info(
                File::basename($file)
                .": "
                .$certificate->getDomain()
                ." --> valid for "
                .$certificate->daysUntilExpirationDate()
                ." days (expiration "
                .$certificate->expirationDate()->format('d-m-Y')
                .")"
            );
        } catch (\Exception $e) {
            $this->warn($file.": is not a valid public certificate");
            return 1;
        }

        return 0;
    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
