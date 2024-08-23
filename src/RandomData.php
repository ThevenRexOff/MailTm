<?php

namespace Thevenrex\MailTm;

class RandomData
{

    public static function randomString($length = 10)
    {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 5)), 0, $length);
    }

    public static function randomUsername()
    {
        return self::randomString(10);
    }

    public static function randomPassword()
    {
        return self::randomString(10);
    }
}
