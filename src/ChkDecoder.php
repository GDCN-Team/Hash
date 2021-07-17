<?php

namespace GDCN\Hash;

use GDCN\Hash\Base\Decoder;
use GDCN\Hash\Enums\XorKeys;

/**
 * Class ChkDecoder
 * @package GDCN\Base
 */
class ChkDecoder
{
    /**
     * @var Decoder
     */
    protected $decoder;

    /**
     * ChkDecoder constructor.
     * @param Decoder $decoder
     */
    public function __construct(Decoder $decoder)
    {
        $this->decoder = $decoder;
    }

    /**
     * @param string $chk
     * @param bool $substr
     * @return string
     */
    public function decodeChallengeChk(string $chk, bool $substr = true): string
    {
        $content = $substr ? substr($chk, 5) : $chk;
        return $this->decoder->decode($content, XorKeys::CHALLENGES);
    }

    /**
     * @param string $chk
     * @param bool $substr
     * @return string
     */
    public function decodeRewardChk(string $chk, bool $substr = true): string
    {
        $content = $substr ? substr($chk, 5) : $chk;
        return $this->decoder->decode($content, XorKeys::REWARDS);
    }
}