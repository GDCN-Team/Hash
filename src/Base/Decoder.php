<?php

namespace GDCN\Hash\Base;

use Base64Url\Base64Url;
use GDCN\XORCipher;

/**
 * Class Decoder
 * @package GDCN\Base
 */
class Decoder
{
    /**
     * @param string $content
     * @return string
     */
    public function base64(string $content): string
    {
        return Base64Url::decode($content);
    }

    /**
     * @param string $content
     * @param string $key
     * @return string
     */
    public function xor(string $content, string $key): string
    {
        return XORCipher::cipher($content, $key);
    }

    /**
     * @param string $content
     * @param string $key
     * @return string
     */
    public function decode(string $content, string $key): string
    {
        return $this->xor($this->base64($content), $key);
    }
}