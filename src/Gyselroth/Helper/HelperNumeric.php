<?php

/**
 * Copyright (c) 2017-2018 gyselroth™  (http://www.gyselroth.net)
 *
 * @package \gyselroth\Helper
 * @author  gyselroth™  (http://www.gyselroth.com)
 * @link    http://www.gyselroth.com
 * @license Apache-2.0
 */

namespace Gyselroth\Helper;

class HelperNumeric
{
    // Byte sizes
    public const BYTES_KILOBYTE    = 1024;
    // 1 MB = 1024 * 1024 bytes
    public const BYTES_MEGABYTE    = 1048576;
    // 1 GB = 1024 * 1024 * 1024 bytes
    public const BYTES_GIGABYTE    = 1073741824;

    public const UNIT_BYTES     = 'B';
    public const UNIT_KILOBYTES = 'KB';
    public const UNIT_MEGABYTES = 'MB';

    /**
     * @param  int|string $number
     * @param  int        $digits
     * @return string
     */
    public static function formatAmountDigits($number, int $digits): string
    {
        $number = (int)$number;
        while (\strlen($number) < $digits) {
            $number = '0' . $number;
        }

        return $number;
    }

    /**
     * @param  array  $array
     * @param  string $glue Default: ','
     * @param  bool   $sort
     * @param  bool   $makeUnique
     * @param  bool   $onlyPositive
     * @return string Imploded (list of) integers
     */
    public static function intImplode(
        array $array,
        string $glue = ',',
        bool $sort = true,
        bool $makeUnique = false,
        bool $onlyPositive = false
    ): string
    {
        $array    = array_unique($array);
        $integers = [];

        foreach ($array as $item) {
            if (is_numeric($item) && (!$onlyPositive || $item > 0)) {
                $integers[] = (int)$item;
            }
        }

        if ($sort) {
            asort($integers);
        }
        if ($makeUnique) {
            $integers = array_unique($integers);
        }

        return implode($integers, $glue);
    }

    /**
     * Split given list of values by given delimiter into a unique array of integers
     *
     * @param  string|null $str
     * @param  string      $delimiter
     * @param  bool        $excludeNullValues Include null values (converted to 0)? Default: true
     * @param  bool        $unique
     * @return int[]
     */
    public static function intExplode(
        ?string $str,
        string $delimiter = ',',
        bool $excludeNullValues = true,
        bool $unique = false
    ): array
    {
        if (null === $str) {
            return [];
        }

        $numbers = [];
        $parts   = explode($delimiter, $str);
        foreach ($parts as $number) {
            if (!$excludeNullValues || 'null' !== strtolower($number)) {
                $numbers[] = (int)$number;
            }
        }

        return $unique ? array_unique($numbers) : $numbers;
    }

    /**
     * Split given list of values by given delimiter into a unique array of float values
     *
     * @param string $str
     * @param string $delimiter
     * @param bool   $excludeNullValues Include null values (converted to 0)? Default: true
     * @param bool   $unique
     * @return array
     */
    public static function floatExplode(
        string $str,
        string $delimiter = ',',
        bool $excludeNullValues = true,
        bool $unique = false
    ): array
    {
        if (null === $str) {
            return [];
        }

        $numbers = [];
        $parts   = explode($delimiter, $str);
        foreach ($parts as $number) {
            if (!$excludeNullValues || 'null' !== strtolower($number)) {
                $numbers[] = (float)$number;
            }
        }

        return $unique ? array_unique($numbers) : $numbers;
    }

    /**
     * Get size and unit (bytes, kilo or megabytes) values from given amount
     *
     * @param  int $bytes Size
     * @return array      Array w/ 'size' and 'unit'
     */
    public static function calcBytesSize($bytes): array
    {
        $bytes = (int)$bytes;
        if ($bytes < 1000) {
            return [
                'size' => $bytes,
                'unit' => self::UNIT_BYTES
            ];
        }

        $kilo = $bytes / 1024;
        if ($kilo < 1000) {
            return [
                'size' => round($kilo, 1),
                'unit' => self::UNIT_KILOBYTES
            ];
        }

        $mega = $bytes / 1024000;

        return [
            'size' => round($mega, 1),
            'unit' => self::UNIT_MEGABYTES
        ];
    }
}
