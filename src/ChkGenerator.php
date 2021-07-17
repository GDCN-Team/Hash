<?php

namespace GDCN\Hash;

use GDCN\Hash\Base\Encoder;
use GDCN\Hash\Enums\Salts;
use GDCN\Hash\Enums\XorKeys;

/**
 * Class ChkGenerator
 * @package GDCN\Chk
 */
class ChkGenerator
{
    /**
     * @var Encoder
     */
    protected $encoder;

    /**
     * ChkGenerator constructor.
     * @param Encoder $encoder
     */
    public function __construct(Encoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param int $levelID
     * @param int $inc
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param int $uuid
     * @param bool $encode
     * @return string
     */
    public function generateChkForDownloadLevel(
        int $levelID,
        int $inc,
        string $rs,
        int $accountID,
        string $udid,
        int $uuid,
        bool $encode = true
    ): string
    {
        $content = $levelID . $inc . $rs . $accountID . $udid . $uuid . Salts::LEVEL;
        return $encode ? $this->encoder->encode($content, XorKeys::LEVEL_SEED) : $content;
    }

    /**
     * @param int $commentType
     * @param string $userName
     * @param string $commentContent
     * @param int $levelID
     * @param int $percentage
     * @param bool $encode
     * @return string
     */
    public function generateChkForUploadComment(
        int $commentType,
        string $userName,
        string $commentContent,
        int $levelID = 0,
        int $percentage = 0,
        bool $encode = true
    ): string
    {
        $content = $userName . $commentContent . $levelID . $percentage . $commentType . Salts::COMMENT;
        return $encode ? $this->encoder->encode($content, XorKeys::COMMENT_CHK) : $content;
    }

    /**
     * @param int $special
     * @param int $itemID
     * @param bool $like
     * @param int $type
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param int $uuid
     * @param bool $encode
     * @return string
     */
    public function generateChkForLike(
        int $special,
        int $itemID,
        bool $like,
        int $type,
        string $rs,
        int $accountID,
        string $udid,
        int $uuid,
        bool $encode = true
    ): string
    {
        $content = $special . $itemID . (int)$like . $type . $rs . $accountID . $udid . $uuid . Salts::LIKE;
        return $encode ? $this->encoder->encode($content, XorKeys::LIKE) : $content;
    }

    /**
     * @param int $levelID
     * @param int $stars
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param int $uuid
     * @param bool $encode
     * @return string
     */
    public function generateChkForRate(
        int $levelID,
        int $stars,
        string $rs,
        int $accountID,
        string $udid,
        int $uuid,
        bool $encode = true
    ): string
    {
        $content = $levelID . $stars . $rs . $accountID . $udid . $uuid . Salts::RATE;
        return $encode ? $this->encoder->encode($content, XorKeys::RATE) : $content;
    }

    /**
     * @param int $accountID
     * @param int $levelID
     * @param int $percentage
     * @param int $jumps
     * @param int $attempts
     * @param string $seed
     * @param string $bestDifferences
     * @param int $coins
     * @param int $timelyID
     * @param string $rs
     * @param bool $encode
     * @return string
     */
    public function generateChkForUploadLevelScore(
        int $accountID,
        int $levelID,
        int $percentage,
        int $jumps,
        int $attempts,
        string $seed,
        string $bestDifferences,
        int $coins,
        int $timelyID,
        string $rs,
        bool $encode = true
    ): string
    {
        $content = $accountID . $levelID . $percentage . $jumps . $attempts . $seed . $bestDifferences . '1' . $coins . $timelyID . $rs . Salts::LEVEL_LEADERBOARD;
        return $encode ? $this->encoder->encode($content, XorKeys::LEVEL_LEADERBOARD) : $content;
    }
}