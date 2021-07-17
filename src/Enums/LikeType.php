<?php

namespace GDCN\Hash\Enums;

/**
 * Class LikeType
 * @package GDCN\Hash\Enums
 */
class LikeType
{
    public const LEVEL = 1;
    public const LEVEL_COMMENT = 2;
    public const OTHER_COMMENT = 3;
    public const ACCOUNT_COMMENT = self::OTHER_COMMENT;
}