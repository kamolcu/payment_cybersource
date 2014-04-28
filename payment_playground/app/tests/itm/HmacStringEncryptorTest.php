<?php

namespace itm;

use \itm\HmacEncryptor;

class HmacStringEncryptorTest extends \PHPUnit_Framework_TestCase{
    Const DEFAULT_ALGO = 'sha256';
    const SECRET_KEY = '0edc79956f674cebb16d480f0b2188b11795a2f38cec49268da09f64b4f05264ce2178e85341499caa7ea4c1f329326a83bef06dcf844d2da74e39709a40a6b2d38960f1d72c4975af785de8bd8406b13ee8c0b524874487ba17cbf1b4c42993802d5de28e29416a880dc77ec4671da32d6d91b98dd347bc94b0911327c68e55';
    public function setUp(){
    }
    public function tearDown(){
    }
    public function testConstructorInvalidArgumentPassing(){
        $arguments = array(
                '',
                array(),
                NULL
        );
        $expected = array(
                'sha256',
                'sha256',
                'sha256'
        );
        for($ii = 0; $ii < count($arguments); $ii++){
            $enc = new HmacEncryptor($arguments[$ii]);
            $this->assertSame($expected[$ii], $enc->getCurrentAlgo());
        }
    }
    public function testInvalidEncryptPass(){
        $enc = new HmacEncryptor();
        $this->assertSame($enc->getCurrentAlgo(), $enc::DEFAULT_ALGO);
        $dataArguments = array(
                '',
                'abc123',
                'abc123',
                'abc123',
                'abc123',
                'abc123',
                array(
                        'a'
                ),
                'abc123'
        );
        $keyArguments = array(
                'key',
                array(),
                NULL,
                'key',
                'key',
                array(
                        'a'
                ),
                'key',
                'key'
        );
        $rawOutputArguments = array(
                true,
                true,
                true,
                '',
                NULL,
                false,
                false,
                array(
                        'a'
                )
        );
        for($ii = 0; $ii < count($dataArguments); $ii++){
            $actual = $enc->encrypt($dataArguments[$ii], $keyArguments[$ii], $rawOutputArguments[$ii]);
            $this->assertSame('', $actual);
        }
    }
    public function testEncryptionSha256(){
        $enc = new HmacEncryptor(); // Use sha256
        $actual = $enc->encrypt('a', 'key', false);
        $this->assertSame('780c3db4ce3de5b9e55816fba98f590631d96c075271b26976238d5f4444219b', $actual);

        $enc = new HmacEncryptor('sha256');
        $actual = $enc->encrypt('abc123', 'secretkey', false);
        $this->assertSame('f6e1a359e16ddc5f8d24f42d9a059643a28b26478659184a8f915e74050b90ce', $actual);

        $actual = base64_encode($enc->encrypt('xxx=abc', HmacStringEncryptorTest::SECRET_KEY, true));
        $this->assertSame('XPySwJhTWNWVYmS9feT7xcTDmJdPtSYXyRs5rkPWRF0=', $actual);

    }
    // TODO: add more test of other encryption method i.e. md5, crc32, 'haval256,5'
}
