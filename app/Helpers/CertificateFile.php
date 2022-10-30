<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class CertificateFile
{
    public static function isPublicCertificate(SplFileInfo $splFileInfo): bool
    {
        $upperExtension = Str::upper($splFileInfo->getExtension());
        if (($upperExtension==="PEM")
            ||($upperExtension==="CER")
            ||($upperExtension==="CRT")){
            if (Str::contains(haystack: $splFileInfo->getContents(),
                needles: "BEGIN CERTIFICATE",
                ignoreCase: true))
            return true;
        }
        if ($upperExtension==="DER") {
            return true;
        }
        return false;
    }
}