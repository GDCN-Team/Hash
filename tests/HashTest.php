<?php

namespace Tests;

use GDCN\Hash;
use PHPUnit\Framework\TestCase;

final class HashTest extends TestCase
{
    public function testGenerateSeed2ForUploadLevel(): void
    {
        self::assertEquals(
            Hash::decode('UQZTBwUHAgFWDVcJClQEUFUCUQUACAEHBVYHUQFXVlQHB1ZSAwcDAw==', Hash::$keys['level_seed']),
            Hash::generateSeed2ForUploadLevel('H4sIAAAAAAAAC6WQwQ3DIAxFF3Ilf4MJUU6ZIQP8AbJCh2-M21uipurlP7DxA7FvpQtYlUaYs9DcCSQskcXKB9gIVeVEEB7RqezEExwKtXsK_K-YTxVxJgduSYwxfyaK3_iI9JvGLzX6y2vahUb2FUU04ImWqHJkrqesvNEDW5nHzkamYDTWOjK70AREFwjE5LikSPXlBVHqbLgdAgAA')
        );
    }

    public function testGenerateChkForDownloadLevel(): void
    {
        self::assertEquals(
            Hash::decode('VQRXD1AAVFMEUVcCClECAAgHBQNRAwNSBAcJBgUCBQZWBwJVUlNWAA==', Hash::$keys['level_seed']),
            Hash::generateChkForDownloadLevel(73, 1, 'ORsI8Yuf6M', 71, 'S1145141919810', '1')
        );
    }

    public function testGenerateChkForUploadUserScore(): void
    {
        self::assertEquals(
            Hash::decode('WQICBQJZUQZTAFkAUFEDAQcGDlBcAwJUAwpUUVFVCQxXA1VZV1RVUw==', Hash::$keys['user']),
            Hash::generateChkForUploadUserScore(71, 0, 0, 0, 0, 0, 4, 0, 4, 1, 1, 1, 1, 1, 0, 1, 1)
        );
    }

    public function testGenerateHashForChallenge(): void
    {
        self::assertEquals(
            '8147707fa1731762dcf5deb019e15ff00c44b6c6',
            Hash::generateHashForChallenge('0vxOdeEoOY34LCAIBDgMBDQYNYggNBgYADwoABQILAAEHBQgPAwUEAA0CDgIOCw0HAQANBgEACQgFDQYIAgwEBg0BDgAdCxQCGwALFFdYWFdLDg8dCBQBAgAVCgYbXktaRw0IFQoYAR0IChhUXlBWRw==', true)
        );
    }

    public function testGenerateLevelStringHashForDownloadLevel(): void
    {
        self::assertEquals(
            '862e55f281e11d46f525b248b5c07396fc5abf10',
            Hash::generateLevelStringHashForDownloadLevel('H4sIAAAAAAAAC6WQwQ3DIAxFF3Ilf4MJUU6ZIQP8AbJCh2-M21uipurlP7DxA7FvpQtYlUaYs9DcCSQskcXKB9gIVeVEEB7RqezEExwKtXsK_K-YTxVxJgduSYwxfyaK3_iI9JvGLzX6y2vahUb2FUU04ImWqHJkrqesvNEDW5nHzkamYDTWOjK70AREFwjE5LikSPXlBVHqbLgdAgAA')
        );
    }

    public function testGenerateChkForUploadAccountComment(): void
    {
        self::assertEquals(
            Hash::decode('Vw5RDQMKDFdbB1RfV1kCBwBWAVAHWwELUgoLDVxVAgpXWQAKWAwNVA==', Hash::$keys['comment']),
            Hash::generateChkForUploadAccountComment('WOSHIZHAZHA120', 'YXdh')
        );
    }

    public function testGenerateChkForUploadLevelComment(): void
    {
        self::assertEquals(
            Hash::decode('UA5VDFUFXQUKVVcBVQhVVAgHAVJWWAwJUANdBggEBg5QDgkCWAUNBg==', Hash::$keys['comment']),
            Hash::generateChkForUploadLevelComment('WOSHIZHAZHA120', 'YXdh', 71)
        );
    }

    public function testGenerateHashForGetLevelGauntlets(): void
    {
        self::assertEquals(
            '104805380e9db3b20a4458812863fa32ce959a0f',
            Hash::generateHashForGetLevelGauntlets([
                ['id' => 1, 'level1' => 2, 'level2' => 3, 'level3' => 4, 'level4' => 5, 'level5' => 6]
            ])
        );
    }

    public function testGenerateHashForGetLevelPacks(): void
    {
        self::assertEquals(
            'a0ea314e6a45b3415c7b51b6df3c4c50003512bf',
            Hash::generateHashForGetLevelPacks([
                ['id' => 1, 'stars' => 1, 'coins' => 1]
            ])
        );
    }

    public function testGenerateLevelHashForDownloadLevel(): void
    {
        self::assertEquals(
            '930d2799c9eb5fb7af5a9b0aa5693bf1552ed601',
            Hash::generateLevelHashForDownloadLevel(1, 0, 0, 73, false, 0, 0)
        );
    }

    public function testGenerateChkForLike(): void
    {
        self::assertEquals(
            Hash::decode('UQsBXgVWCAUIBlZdB1wCDQ1UXFIGCVcJUFAIAl0ADV5QCFQADgpbBA==', Hash::$keys['like']),
            Hash::generateChkForLike(0, 71, true, 1, 'WuRRD8lGZ7', 71, 'S1145141919810', 1)
        );
    }

    public function testGenerateHashForSearchLevel(): void
    {
        self::assertEquals(
            'dfe0ed3c538c6ab0c4d1bd3107dcf702a44c0ee1',
            Hash::generateHashForSearchLevel([
                ['id' => 71, 'coin_verified' => false, 'stars' => 10]
            ])
        );
    }

    public function testGenerateHashForGetReward(): void
    {
        self::assertEquals(
            '59edfe79acc22ceb266b1d56df4d2d3a48b2029e',
            Hash::generateHashForGetReward('jEJuWeXFpT3QPCgsNCwcBBAoIZggECgMEDwMMAAYLCQ0CAQgGDwAAAAQOCwYOAgECBQAECgQECQEJCAUDAQIBBw0dDh4GFQMCCAUDAg0LBxUJCB4DFQICCAU=', true)
        );
    }

    public function testGenerateChkForRate(): void
    {
        self::assertEquals(
            Hash::decode('V10LXlcNCgoIAFQPUA4EBgALCwcCDVEOBQNdUV5TAF0BCgMHXAMABw==', Hash::$keys['rate']),
            Hash::generateChkForRate(72, 10, '4OG2Gy0hql', 71, 'S1145141919810', 1)
        );
    }
}