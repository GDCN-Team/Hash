<?php

namespace GDCN\Hash;

use GDCN\Hash\Base\Encoder;
use GDCN\Hash\Enums\Salts;
use GDCN\Hash\Enums\XorKeys;

/**
 * Class HashGenerator
 * @package GDCN\Base
 */
class HashGenerator
{
    /**
     * @var Encoder
     */
    protected $encoder;

    /**
     * HashGenerator constructor.
     * @param Encoder $encoder
     */
    public function __construct(Encoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param string $levelString
     * @param bool $encode
     * @return string
     */
    public function generateSeed2ForUploadLevel(
        string $levelString,
        bool $encode = true
    ): string
    {
        $hash = null;
        if (strlen($levelString) < 50) {
            return $levelString;
        }

        $length = strlen($levelString);
        $divided = (int)($length / 50);

        $len = 0;
        for ($i = 0; $i < $length; $i += $divided) {
            if ($len > 49) {
                break;
            }

            $hash .= $levelString[$i];
            $len++;
        }

        $content = $hash . Salts::LEVEL;
        return $encode ? $this->encoder->encode($content, XorKeys::LEVEL_SEED) : $content;
    }

    /**
     * @param int $accountID
     * @param int $userCoins
     * @param int $demons
     * @param int $stars
     * @param int $coins
     * @param int $iconType
     * @param int $icon
     * @param int $diamonds
     * @param int $cubeID
     * @param int $shipID
     * @param int $ballID
     * @param int $ufoID
     * @param int $waveID
     * @param int $robotID
     * @param bool $glow
     * @param int $spiderID
     * @param int $explosionID
     * @param bool $encode
     * @return string
     */
    public function generateSeed2ForUpdateUserScore(
        int $accountID,
        int $userCoins,
        int $demons,
        int $stars,
        int $coins,
        int $iconType,
        int $icon,
        int $diamonds,
        int $cubeID,
        int $shipID,
        int $ballID,
        int $ufoID,
        int $waveID,
        int $robotID,
        bool $glow,
        int $spiderID,
        int $explosionID,
        bool $encode = true
    ): string
    {
        $content = $accountID . $userCoins . $demons . $stars . $coins . $iconType . $icon . $diamonds . $cubeID . $shipID . $ballID . $ufoID . $waveID . $robotID . (int)$glow . $spiderID . $explosionID . Salts::USER_PROFILE;
        return $encode ? $this->encoder->encode($content, XorKeys::USER_PROFILE) : $content;
    }
}