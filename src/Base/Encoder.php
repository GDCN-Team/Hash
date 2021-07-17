<?php

namespace GDCN\Hash\Base;

use Base64Url\Base64Url;
use GDCN\XORCipher;

/**
 * Class Encoder
 * @package GDCN
 */
class Encoder
{
    /**
     * @param string $content
     * @return string
     */
    public function sha1(string $content): string
    {
        return hash('sha1', $content);
    }

    /**
     * @param string $content
     * @param bool $padding
     * @return string
     */
    public function base64(string $content, bool $padding = true): string
    {
        return Base64Url::encode($content, $padding);
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
     * @param bool $padding
     * @return string
     */
    public function encode(string $content, string $key, bool $padding = true): string
    {
        return $this->base64($this->xor($this->sha1($content), $key), $padding);
    }
}