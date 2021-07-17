<?php

namespace GDCN\Hash\Enums;

/**
 * Class XorKeys
 * @package GDCN\Enums
 *
 * @see https://docs.gdprogra.me/#/topics/encryption/xor?id=xor-keys
 */
class XorKeys
{
    public const MESSAGES = 14521;
    public const LEVEL_PASSWORD = 26364;
    public const ACCOUNT_PASSWORD = 37526;
    public const LEVEL_LEADERBOARD = 39673;
    public const LEVEL_SEED = 41274;
    public const COMMENT_CHK = 29481;
    public const CHALLENGES = 19847;
    public const REWARDS = 59182;
    public const LIKE = 58281;
    public const RATE = self::LIKE;
    public const USER_PROFILE = 85271;
    public const VAULT_CODES = 19283;
    public const LOAD_DATA = 48291;
}