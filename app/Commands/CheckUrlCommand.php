<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Spatie\SslCertificate\SslCertificate;

class CheckUrlCommand extends Command
{
    protected $signature = 'check:url
                            {url : site to check (required)}
                            ';

    protected $description = 'Get validity of the certificate of a site';

    public function handle(): mixed
    {
        $this->info("");
        $url = $this->argument('url');

        try {
            $certificate = SslCertificate::createForHostName($url);
            $this->table(['URL', $url],[
                ['Domain/CN', $certificate->getDomain()],
                ['Issuer', $certificate->getIssuer()],
                ['Organization', $certificate->getOrganization()],
                ['Serial number', $certificate->getSerialNumber()],
                ['Valid for', $certificate->daysUntilExpirationDate()." days"],
                ['Valid until', $certificate->expirationDate()->format('d-m-Y')],
            ]);
        } catch (\Exception $e) {
            $this->warn($url.": is not a valid SSL Site");
            return 1;
        }

        return 0;
    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
