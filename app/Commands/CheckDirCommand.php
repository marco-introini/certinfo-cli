<?php

namespace App\Commands;

use App\Enums\CertTypeEnum;
use App\Helpers\CertificateFile;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;
use Spatie\SslCertificate\SslCertificate;

class CheckDirCommand extends Command
{
    protected $signature = 'check:directory
                            {directory : the directory to scan (required)}
                            ';

    protected $description = 'Get the list of CN of certificates inside the specified directory';

    public function handle(): int
    {
        $directory = $this->argument('directory');
        $this->info('');

        if (! File::isDirectory($directory)) {
            $this->error("$directory is NOT a directory");

            return 1;
        }

        $certData = [];

        foreach (File::files($directory) as $file) {
            $certificateFile = new CertificateFile($file->getPathname());
            if ($certificateFile->certType() == CertTypeEnum::UNKNOWN) {
                continue;
            }

            try {
                $certificate = SslCertificate::createFromFile($file->getPathname());
                $certData[] = [
                    $file->getBasename(),
                    $certificate->getDomain(),
                    $certificate->expirationDate()->format('d-m-Y'),
                    $certificate->daysUntilExpirationDate().' days',
                ];
            } catch (\Exception $e) {
                $this->warn($file->getBasename().': is not a valid public certificate');

                return 1;
            }
        }

        $this->table(['Filename', 'Domain/CN', 'Expiration', 'Valid for'], $certData);

        return 0;
    }
}
