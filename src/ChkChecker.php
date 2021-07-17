<?php

namespace GDCN\Hash;

use GDCN\Hash\Base\Decoder;
use GDCN\Hash\Enums\XorKeys;

/**
 * Class ChkChecker
 * @package GDCN\Hash
 */
class ChkChecker
{
    /**
     * @var Decoder
     */
    protected $decoder;

    /**
     * @var ChkGenerator
     */
    protected $chkGenerator;

    /**
     * ChkChecker constructor.
     * @param ChkGenerator $chkGenerator
     * @param Decoder $decoder
     */
    public function __construct(ChkGenerator $chkGenerator, Decoder $decoder)
    {
        $this->chkGenerator = $chkGenerator;
        $this->decoder = $decoder;
    }

    /**
     * @param string $chk
     * @param int $levelID
     * @param int $inc
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param int $uuid
     * @return bool
     */
    public function checkDownloadLevelChk(
        string $chk,
        int $levelID,
        int $inc,
        string $rs,
        int $accountID,
        string $udid,
        int $uuid
    ): bool
    {
        return hash_equals(
            $this->chkGenerator->generateChkForDownloadLevel($levelID, $inc, $rs, $accountID, $udid, $uuid, false),
            $this->decoder->decode($chk, XorKeys::LEVEL_SEED)
        );
    }

    /**
     * @param string $chk
     * @param int $commentType
     * @param string $userName
     * @param string $commentContent
     * @param int $levelID
     * @param int $percentage
     * @return bool
     */
    public function checkUploadCommentChk(
        string $chk,
        int $commentType,
        string $userName,
        string $commentContent,
        int $levelID = 0,
        int $percentage = 0
    ): bool
    {
        return hash_equals(
            $this->chkGenerator->generateChkForUploadComment($commentType, $userName, $commentContent, $levelID, $percentage, false),
            $this->decoder->decode($chk, XorKeys::COMMENT_CHK)
        );
    }

    /**
     * @param string $chk
     * @param int $special
     * @param int $itemID
     * @param bool $like
     * @param int $type
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param int $uuid
     * @return bool
     */
    public function checkLikeChk(
        string $chk,
        int $special,
        int $itemID,
        bool $like,
        int $type,
        string $rs,
        int $accountID,
        string $udid,
        int $uuid
    ): bool
    {
        return hash_equals(
            $this->chkGenerator->generateChkForLike($special, $itemID, $like, $type, $rs, $accountID, $udid, $uuid, false),
            $this->decoder->decode($chk, XorKeys::LIKE)
        );
    }

    /**
     * @param string $chk
     * @param int $levelID
     * @param int $stars
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param int $uuid
     * @return bool
     */
    public function checkRateChk(
        string $chk,
        int $levelID,
        int $stars,
        string $rs,
        int $accountID,
        string $udid,
        int $uuid
    ): bool
    {
        return hash_equals(
            $this->chkGenerator->generateChkForRate($levelID, $stars, $rs, $accountID, $udid, $uuid, false),
            $this->decoder->decode($chk, XorKeys::RATE)
        );
    }

    /**
     * @param string $chk
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
     * @return bool
     */
    public function checkUploadLevelScoreChk(
        string $chk,
        int $accountID,
        int $levelID,
        int $percentage,
        int $jumps,
        int $attempts,
        string $seed,
        string $bestDifferences,
        int $coins,
        int $timelyID,
        string $rs
    ): bool
    {
        return hash_equals(
            $this->chkGenerator->generateChkForUploadLevelScore($accountID, $levelID, $percentage, $jumps, $attempts, $seed, $bestDifferences, $coins, $timelyID, $rs, false),
            $this->decoder->decode($chk, XorKeys::LEVEL_LEADERBOARD)
        );
    }
}