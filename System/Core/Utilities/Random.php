<?php

/* =================================
 * CreationShare Platform
 *
 * (c) CreationShare Technology LLC
 * =================================
 */

class Random {
    static function getText($length) {
        $possible = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $possible .= "1234567890";

        $result = "";
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, strlen($possible)-1);
            $result .= substr($possible, $index, 1);
        }
        return $result;
    }

	static function getKey($length) {
        $possible = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $possible .= "1234567890!@#$%^&*;',.<>[]{}()/-_=";

        $result = "";
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, strlen($possible)-1);
            $result .= substr($possible, $index, 1);
        }
        return $result;
    }
}