<?php

namespace App\Support;

class StrHelper
{
    public static function slug(string $value)
    {
         return \Illuminate\Support\Str::slug($value) . '-' .mt_rand(785, 15685) . time();
    }
}
