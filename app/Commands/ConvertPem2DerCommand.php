<?php

namespace App\Commands;

use App\Enums\CertTypeEnum;
use App\Helpers\CertificateConversion;
use App\Helpers\CertificateFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class ConvertPem2DerCommand extends Command
{
    protected $signature = 'convert:pem2der
                            {file : the certificate file (required)}
                            ';

    protected $description = 'Convert PEM certificate to DER';

    public function handle(): int
    {
        $this->info('');
        $file = $this->argument('file');

        if (! File::isFile($file)) {
            $this->error("$file is NOT a valid file");

            return 1;
        }
        $certificateFile = new CertificateFile($file);
        if ($certificateFile->certType() != CertTypeEnum::PEM) {
            $this->error("$file is NOT a valid PEM file certificate");

            return 1;
        }
        $derFile = File::dirname($file).'/'.File::name($file).'.DER';
        $derContents = CertificateConversion::pem2der(File::get($file));
        File::put($derFile, $derContents);

        $this->info(File::name($file).'.DER created successfully');

        return 0;
    }

}
