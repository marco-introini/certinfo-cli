<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Spatie\SslCertificate\SslCertificate;

class CommonNamesCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'certificate:common-names
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
    public function handle(): void
    {
        $directory = $this->argument('directory');

        $this->warn("Working on $directory");

        $certificate = SslCertificate::createFromFile($directory);

        echo $certificate->getDomain();

        $this->info('Operation executed');
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
