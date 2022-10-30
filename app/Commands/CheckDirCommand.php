<?php

namespace App\Commands;

use App\Helpers\CertificateFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Spatie\SslCertificate\SslCertificate;

class CheckDirCommand extends Command
{
    protected $signature = 'certificate:check-dir
                            {directory : the directory to scan (required)}
                            {--zip : check inside zip files (optional)}
                            ';

    protected $description = 'Get the list of CN of certificates inside the specified directory';

    public function handle(): mixed
    {
        $directory = $this->argument('directory');
        $this->info("");

        if (!File::isDirectory($directory)) {
            $this->error("$directory is NOT a directory");
            return 1;
        }

        foreach (File::files($directory) as $file){
            if (!CertificateFile::isPublicCertificate($file->getPathname()))
                continue;

            try {
                $certificate = SslCertificate::createFromFile($file->getPathname());
                $this->info($file->getBasename()
                    . ": "
                    .$certificate->getDomain()
                    ." --> valid for "
                    .$certificate->daysUntilExpirationDate()
                    ." days (expiration "
                    .$certificate->expirationDate()->format('d-m-Y')
                    .")");
            }
            catch (\Exception $e) {
                $this->warn($file->getBasename(). ": is not a valid public certificate");
                return 1;
            }
        }

        return 0;
    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
