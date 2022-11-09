<?php

namespace App\Enums;

enum CertTypeEnum: string
{
    case PEM = "PEM Certificate";
    case PKCS7 = "PKCS7";
    case PKCS12 = "PKCS12 keystore";
    case DER = "DER Certificate";
    case UNKNOWN = "Unknown Certificate Type";
}