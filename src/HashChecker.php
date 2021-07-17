<?php

namespace GDCN\Hash;

use GDCN\Hash\Base\Decoder;
use GDCN\Hash\Enums\XorKeys;

/**
 * Class HashChecker
 * @package GDCN\Hash
 */
class HashChecker
{
    /**
     * @var Decoder
     */
    protected $decoder;

    /**
     * @var HashGenerator
     */
    protected $hashGenerator;

    /**
     * HashChecker constructor.
     * @param Decoder $decoder
     * @param HashGenerator $hashGenerator
     */
    public function __construct(Decoder $decoder, HashGenerator $hashGenerator)
    {
        $this->decoder = $decoder;
        $this->hashGenerator = $hashGenerator;
    }

    /**
     * @param string $seed2
     * @param string $levelString
     * @return bool
     */
    public function checkUploadLevelSeed2(
        string $seed2,
        string $levelString
    ): bool
    {
        return hash_equals(
            $this->hashGenerator->generateSeed2ForUploadLevel($levelString, false),
            $this->decoder->decode($seed2, XorKeys::LEVEL_SEED)
        );
    }

    /**
     * @param string $seed2
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
     * @return bool
     */
    public function checkUpdateUserScoreSeed2(
        string $seed2,
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
        int $explosionID
    ): bool
    {
        return hash_equals(
            $this->hashGenerator->generateSeed2ForUpdateUserScore($accountID, $userCoins, $demons, $stars, $coins, $iconType, $icon, $diamonds, $cubeID, $shipID, $ballID,$ufoID,$waveID, $robotID,$glow,$spiderID,$explosionID, false),
            $this->decoder->decode($seed2, XorKeys::USER_PROFILE)
        );
    }
}