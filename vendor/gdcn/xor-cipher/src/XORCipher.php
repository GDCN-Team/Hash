<?php
/*
 * Copyright (c) 2020. WOSHIZHAZHA120
 */

namespace GDCN;

/**
 * Class XORCipher
 * @package XORCipher
 */
class XORCipher
{
    public static function cipher($data, $key): string
    {
        $data = array_map('ord', str_split($data));
        $key = array_map('ord', str_split($key));

        $result = null;
        foreach ($data as $i => $v) {
            $result .= chr($v ^ $key[$i % count($key)]);
        }

        return $result;
    }
}