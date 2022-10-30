<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CertificateFile
{
    public static function isPublicCertificate(string $filePath): bool
    {
        $upperExtension = Str::upper(File::extension($filePath));
        if (($upperExtension==="PEM")
            || ($upperExtension==="CER")
            || ($upperExtension==="CRT")){
            if (Str::contains(haystack: File::get($filePath),
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