<?php

namespace App\Commands;

use App\Enums\CertTypeEnum;
use App\Helpers\CertificateConversion;
use App\Helpers\CertificateFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class ConvertDer2PemCommand extends Command
{
    protected $signature = 'convert:der2pem
                            {file : the certificate file (required)}
                            ';

    protected $description = 'Convert DER certificate to PEM';

    public function handle(): int
    {
        $this->info('');
        $file = $this->argument('file');

        if (! File::isFile($file)) {
            $this->error("$file is NOT a valid file");

            return 1;
        }
        $certificateFile = new CertificateFile($file);
        if ($certificateFile->certType() != CertTypeEnum::DER) {
            $this->error("$file is NOT a valid DER file certificate");

            return 1;
        }
        $pemFile = File::dirname($file).'/'.File::name($file).'.PEM';
        $pemContents = CertificateConversion::der2pem(File::get($file));
        File::put($pemFile, $pemContents);

        $this->info(File::name($file).'.PEM created successfully');

        return 0;
    }

}
