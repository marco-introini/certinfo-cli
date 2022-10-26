<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Spatie\SslCertificate\SslCertificate;

class CommonNamesCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'certificate:check-dir
                            {directory : the directory to scan (required)}
                            {--zip : check inside zip files (optional)}
                            ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get the list of CN of certificates inside the specified directory';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): mixed
    {
        $directory = $this->argument('directory');
        $this->info("");

        if (!File::isDirectory($directory)) {
            $this->error("$directory is NOT a directory");
            return 1;
        }

        foreach (File::files($directory) as $file){
            if (($file->getExtension()!=="pem")&&($file->getExtension()!=="PEM"))
                continue;
            //$this->info("Found ".$file->getBasename());

            try {
                $certificate = SslCertificate::createFromFile($file->getPathname());
                $this->info($file->getBasename(). ": ". $certificate->getDomain(). " --> valid for ".$certificate->daysUntilExpirationDate()." days");
            }
            catch (\Exception $e) {
                $this->warn($file->getBasename(). ": is not a valid public certificate");
            }
        }

        return true;
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
