<?php

namespace App\Helpers;

use App\Enums\CertTypeEnum;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CertificateFile
{

    private string $filePath;
    private CertTypeEnum $certType = CertTypeEnum::UNKNOWN;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $upperExtension = Str::upper(File::extension($this->filePath));
        if (($upperExtension === "PEM")
            || ($upperExtension === "CER")
            || ($upperExtension === "CRT")) {
            if (Str::contains(
                haystack: File::get($this->filePath),
                needles: "BEGIN CERTIFICATE",
                ignoreCase: true
            )) {
                $this->certType = CertTypeEnum::PEM;
                return;
            }
        }
        if ($upperExtension === "DER") {
            $this->certType = CertTypeEnum::DER;
            return;
        }
    }

    public function certType(): CertTypeEnum
    {
        return $this->certType;
    }

}