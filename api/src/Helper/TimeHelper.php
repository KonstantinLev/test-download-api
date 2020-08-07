<?php

namespace App\Helper;

class TimeHelper
{
    public static function format($s): string
    {
        $result = [];

        $result[] = floor($s / 86400);
        $s = $s % 86400;

        $result[] = floor($s / 3600);
        $s = $s % 3600;

        $result[] = floor($s / 60);
        $result[] = $s % 60;

        return implode(':', $result);
    }
}