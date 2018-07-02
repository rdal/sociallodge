<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 14/04/15
 * Time: 14:00
 */

class Util {
    const ENTERED_APPRENTICE = 1;
    const FELLOW_CRAFT = 2;
    const MASTER_MASON = 3;

    public static function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    public static function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }
} 