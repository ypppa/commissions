<?php

namespace Ypppa\Commissions\Utils;

class CountryHelper
{
    private static array $euCountries = [
        'AT' => true,
        'BE' => true,
        'BG' => true,
        'CY' => true,
        'CZ' => true,
        'DE' => true,
        'DK' => true,
        'EE' => true,
        'ES' => true,
        'FI' => true,
        'FR' => true,
        'GR' => true,
        'HR' => true,
        'HU' => true,
        'IE' => true,
        'IT' => true,
        'LT' => true,
        'LU' => true,
        'LV' => true,
        'MT' => true,
        'NL' => true,
        'PO' => true,
        'PT' => true,
        'RO' => true,
        'SE' => true,
        'SI' => true,
        'SK' => true,
    ];

    public static function isEUCountry(string $alpha2CountryCode): bool
    {
        return isset(CountryHelper::$euCountries[$alpha2CountryCode]);
    }
}