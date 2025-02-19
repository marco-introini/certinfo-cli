<?php

namespace App\Commands;

use App\Enums\CertTypeEnum;
use App\Helpers\CertificateFile;
use Exception;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Spatie\SslCertificate\SslCertificate;

class CheckSingleFileCommand extends Command
{
    protected $signature = 'check:file
                            {file : the certificate file (required)}
                            ';

    protected $description = 'Get validity of a single certificate';

    public function handle(): int
    {
        $this->info('');
        $file = $this->argument('file');

        if (! File::isFile($file)) {
            $this->error("$file is NOT a valid file");

            return 1;
        }
        $certificateFile = new CertificateFile($file);
        if ($certificateFile->certType() == CertTypeEnum::UNKNOWN) {
            $this->error("$file is NOT a valid file");

            return 1;
        }

        try {
            $certificate = SslCertificate::createFromFile($file);
            $this->table(['Filename', File::basename($file)], [
                ['Domain/CN', $certificate->getDomain()],
                ['Issuer', $certificate->getIssuer()],
                ['Organization', $certificate->getOrganization()],
                ['Serial number', $certificate->getSerialNumber()],
                ['Valid for', $certificate->daysUntilExpirationDate().' days'],
                ['Valid until', $certificate->expirationDate()->format('d-m-Y')],
            ]);
        } catch (Exception $e) {
            $this->warn($file.': is not a valid public certificate');

            return 1;
        }

        return 0;
    }

}
