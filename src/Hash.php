<?php

namespace GDCN;

use Base64Url\Base64Url;

/**
 * Class Hash
 * @package GDCN
 */
class Hash
{
    public const SHA1 = 1 << 1;
    public const BASE64 = 1 << 2;
    public const XOR = 1 << 3;
    public const ENCODE = self::BASE64 + self:: XOR;

    /**
     * @var int[]
     */
    public $keys = [
        'message' => 14251,
        'level_password' => 26364,
        'account_password' => 37526,
        'level_score' => 39673,
        'level_seed' => 41274,
        'comment' => 29481,
        'challenge' => 19847,
        'reward' => 59182,
        'like' => 58281,
        'rate' => 58281,
        'user' => 85271,
        'vault' => 19283
    ];

    /**
     * @var string[]
     */
    protected $salts = [
        'level' => 'xI25fpAapCQg',
        'comment' => 'xPT6iUrtws0J',
        'like' => 'ysg6pUrtjn0J',
        'rate' => 'ysg6pUrtjn0J',
        'user' => 'xI35fsAapCRg',
        'level_score' => 'yPg6pUrtWn0J',
        'challenge' => 'oC36fpYaPtdg',
        'reward' => 'pC26fpYaQCtg'
    ];

    /**
     * @param string $hash
     * @param string $key
     * @param bool $base64
     * @return string
     */
    public function encode(string $hash, string $key, bool $base64 = true): string
    {
        $hash = XORCipher::cipher($hash, $key);
        return $base64 ? Base64Url::encode($hash, true) : $hash;
    }

    /**
     * @param string $hash
     * @param string $key
     * @param bool $base64
     * @return string
     */
    public function decode(string $hash, string $key, bool $base64 = true): string
    {
        if ($base64) {
            $hash = Base64Url::decode($hash);
        }

        return XORCipher::cipher($hash, $key);
    }

    /**
     * @param string $levelString
     * @return string
     */
    public function generateSeed2ForUploadLevel(string $levelString): string
    {
        $hash = null;
        $len = strlen($levelString);
        $divided = (int)($len / 50);

        $p = 0;
        for ($k = 0; $k < $len; $k += $divided) {
            if ($p > 49) {
                break;
            }

            $hash .= $levelString[$k];
            $p++;
        }

        $salt = $this->salts['level'];
        return sha1("{$hash}{$salt}");
    }

    /**
     * @param int $levelID
     * @param int $inc
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param string $uuid
     * @param bool $encode
     * @return string|null
     */
    public function generateChkForDownloadLevel(int $levelID, int $inc, string $rs, int $accountID, string $udid, string $uuid, bool $encode = false): ?string
    {
        return $this->mix("{$levelID}{$inc}{$rs}{$accountID}{$udid}{$uuid}{$this->salts['level']}", $encode ? self::ENCODE : self::SHA1, [
            'key' => $this->keys['level_seed']
        ]);
    }

    /**
     * @param string $hash
     * @param int $mode
     * @param array $options
     * @return string|null
     */
    protected function mix(string $hash, int $mode, $options = []): ?string
    {
        switch ($mode) {
            case self::SHA1:
                return sha1($hash);
            case self::BASE64:
                return Base64Url::encode($hash, $options['up'] ?? true);
            case self:: XOR:
                return XORCipher::cipher($hash, $options['key'] ?? 0);
            case self::BASE64 + self:: XOR:
                return Base64Url::encode(
                    XORCipher::cipher($hash, $options['key'] ?? 0),
                    $options['up'] ?? true);
            default:
                return null;
        }
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
     * @param int $accIcon
     * @param int $accShip
     * @param int $accBall
     * @param int $accBird
     * @param int $accDart
     * @param int $accRobot
     * @param int $accGlow
     * @param int $accSpider
     * @param int $accExplosion
     * @param bool $encode
     * @return string|null
     */
    public function generateChkForUploadUserScore(int $accountID, int $userCoins, int $demons, int $stars, int $coins, int $iconType, int $icon, int $diamonds, int $accIcon, int $accShip, int $accBall, int $accBird, int $accDart, int $accRobot, int $accGlow, int $accSpider, int $accExplosion, bool $encode = false): ?string
    {
        return $this->mix("{$accountID}{$userCoins}{$demons}{$stars}{$coins}{$iconType}{$icon}{$diamonds}{$accIcon}{$accShip}{$accBall}{$accBird}{$accDart}{$accRobot}{$accGlow}{$accSpider}{$accExplosion}{$this->salts['user']}", $encode ? self::ENCODE : self::SHA1, [
            'key' => $this->keys['user']
        ]);
    }

    /**
     * @param string $challengeString
     * @param bool $removeFiveCharacters
     * @param bool $encode
     * @return string|null
     */
    public function generateHashForChallenge(string $challengeString, bool $removeFiveCharacters = false, bool $encode = false): ?string
    {
        if ($removeFiveCharacters) {
            $challengeString = substr($challengeString, 5);
        }

        return $this->mix("{$challengeString}{$this->salts['challenge']}", $encode ? self::ENCODE : self::SHA1, [
            'key' => $this->keys['challenge']
        ]);
    }

    /**
     * @param string $levelString
     * @return string
     */
    public function generateLevelStringHashForDownloadLevel(string $levelString): string
    {
        $hash = 'aaaaa';
        $len = strlen($levelString);
        $divided = (int)($len / 40);

        $p = 0;
        for ($k = 0; $k < $len; $k += $divided) {
            if ($p > 39) {
                break;
            }

            $hash[$p] = $levelString[$k];
            $p++;
        }

        $salt = $this->salts['level'];
        return sha1("{$hash}{$salt}");
    }

    /**
     * @param string $userName
     * @param string $comment
     * @param bool $encode
     * @return string|null
     */
    public function generateChkForUploadAccountComment(string $userName, string $comment, bool $encode = false): ?string
    {
        return $this->mix("{$userName}{$comment}001{$this->salts['comment']}", $encode ? self::ENCODE : self::SHA1, [
            'key' => $this->keys['comment']
        ]);
    }

    /**
     * @param string $userName
     * @param string $comment
     * @param int $levelID
     * @param int $percent
     * @param bool $encode
     * @return string|null
     */
    public function generateChkForUploadLevelComment(string $userName, string $comment, int $levelID, int $percent = 0, bool $encode = false): ?string
    {
        return $this->mix("{$userName}{$comment}{$levelID}{$percent}0{$this->salts['comment']}", $encode ? self::ENCODE : self::SHA1, [
            'key' => $this->keys['comment']
        ]);
    }

    /**
     * @param array $gauntlets
     * @param string $key
     * @param callable|null $generateLevelsFunction
     * @return string|null
     */
    public function generateHashForGetLevelGauntlets(array $gauntlets, string $key = 'id', callable $generateLevelsFunction = null): ?string
    {
        $hash = implode(null, array_map(static function ($gauntlet) use ($key, $generateLevelsFunction) {
            $levels = $generateLevelsFunction ? $generateLevelsFunction($gauntlet) : "{$gauntlet['level1']}{$gauntlet['level2']}{$gauntlet['level3']}{$gauntlet['level4']}{$gauntlet['level5']}";
            return "{$gauntlet[$key]}$levels";
        }, $gauntlets));

        return $this->mix("{$hash}{$this->salts['level']}", self::SHA1);
    }

    /**
     * @param array $packs
     * @param string $key
     * @param string $starsKey
     * @param string $coinsKey
     * @return string|null
     */
    public function generateHashForGetLevelPacks(array $packs, string $key = 'id', string $starsKey = 'stars', string $coinsKey = 'coins'): ?string
    {
        $hash = implode(null, array_map(static function ($pack) use ($coinsKey, $starsKey, $key) {
            $id = (string)$pack[$key];
            return "{$id[0]}{$id[-1]}{$pack[$starsKey]}{$pack[$coinsKey]}";
        }, $packs));

        return $this->mix("{$hash}{$this->salts['level']}", self::SHA1);
    }

    /**
     * @param int $userID
     * @param int $stars
     * @param bool $demon
     * @param int $levelID
     * @param bool $coinVerified
     * @param int $featuredScore
     * @param int $password
     * @param int|null $feaID
     * @return string|null
     */
    public function generateLevelHashForDownloadLevel(int $userID, int $stars, bool $demon, int $levelID, bool $coinVerified, int $featuredScore, int $password, ?int $feaID = null): ?string
    {
        return $this->mix("{$userID},{$stars},{$this->bool2int($demon)},{$levelID},{$this->bool2int($coinVerified)},{$featuredScore},{$password},{$feaID}{$this->salts['level']}", self::SHA1);
    }

    /**
     * @param bool $flag
     * @return int
     */
    protected function bool2int(bool $flag): int
    {
        return $flag ? 1 : 0;
    }

    /**
     * @param int $special
     * @param int $itemID
     * @param bool $like
     * @param int $type
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param string $uuid
     * @return string|null
     */
    public function generateChkForLike(int $special, int $itemID, bool $like, int $type, string $rs, int $accountID, string $udid, string $uuid): ?string
    {
        return $this->mix("{$special}{$itemID}{$this->bool2int($like)}{$type}{$rs}{$accountID}{$udid}{$uuid}{$this->salts['like']}", self::SHA1);
    }

    /**
     * @param array $levels
     * @param string $key
     * @param string $coinVerifiedKey
     * @param string $starsKey
     * @return string|null
     */
    public function generateHashForSearchLevel(array $levels, string $key = 'id', string $coinVerifiedKey = 'coin_verified', string $starsKey = 'stars'): ?string
    {
        $hash = implode(null, array_map(function ($level) use ($starsKey, $coinVerifiedKey, $key) {
            $levelID = (string)$level[$key];
            $coinVerified = $level[$coinVerifiedKey] ?? 0;
            $stars = $level[$starsKey] ?? 0;

            return "{$levelID[0]}{$levelID[-1]}{$stars}{$this->bool2int($coinVerified)}";
        }, $levels));

        return $this->mix("{$hash}{$this->salts['level']}", self::SHA1);
    }

    /**
     * @param string $rewardString
     * @return string|null
     */
    public function generateHashForGetReward(string $rewardString): ?string
    {
        return $this->mix("{$rewardString}{$this->salts['reward']}", self::SHA1);
    }

    /**
     * @param string $generatedHash
     * @param string $userProvidedHash
     * @throws ChkValidationException
     */
    public function check(string $generatedHash, string $userProvidedHash): void
    {
        if ($generatedHash !== $userProvidedHash) {
            throw new ChkValidationException($generatedHash . ' not equal as ' . $userProvidedHash);
        }
    }

    /**
     * @param int $accountID
     * @param int $levelID
     * @param int $percent
     * @param int $seconds
     * @param int $jumps
     * @param int $attempts
     * @param string $seed
     * @param string $bestDifferences
     * @param int $coins
     * @param int $timelyID
     * @param string $rs
     * @param bool $encode
     * @return string|null
     *
     * @deprecated Unusable
     */
    public function generateChkForUploadLevelScore(int $accountID, int $levelID, int $percent, int $seconds, int $jumps, int $attempts, string $seed, string $bestDifferences, int $coins, int $timelyID, string $rs, bool $encode = false): ?string
    {
        return $this->mix("{$accountID}{$levelID}{$percent}{$seconds}{$jumps}{$attempts}{$seed}{$bestDifferences}1{$coins}{$timelyID}{$rs}{$this->salts['level_score']}", $encode ? self::ENCODE : self::SHA1, [
            $this->keys['level_score']
        ]);
    }

    /**
     * @param int $levelID
     * @param int $stars
     * @param string $rs
     * @param int $accountID
     * @param string $udid
     * @param string $uuid
     * @param bool $encode
     * @return string|null
     */
    public function generateChkForRate(int $levelID, int $stars, string $rs, int $accountID, string $udid, string $uuid, bool $encode = false): ?string
    {
        return $this->mix("{$levelID}{$stars}{$rs}{$accountID}{$udid}{$uuid}{$this->salts['rate']}", $encode ? self::ENCODE : self::SHA1, [
            'key' => $this->keys['rate']
        ]);
    }
}