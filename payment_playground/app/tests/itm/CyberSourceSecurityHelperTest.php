<?php

namespace itm;

use \itm\CyberSourceSecurityHelper;

class CyberSourceSecurityHelperTest extends \PHPUnit_Framework_TestCase{
    const SECRET_KEY = '0edc79956f674cebb16d480f0b2188b11795a2f38cec49268da09f64b4f05264ce2178e85341499caa7ea4c1f329326a83bef06dcf844d2da74e39709a40a6b2d38960f1d72c4975af785de8bd8406b13ee8c0b524874487ba17cbf1b4c42993802d5de28e29416a880dc77ec4671da32d6d91b98dd347bc94b0911327c68e55';
    private $securityHelper;
    private $REAL_PARAMS = array(
            'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,bill_to_address_postal_code',
            'access_key' => 'b43c2f909f86361196b5e22007ce4e90',
            'profile_id' => 'ba_pf3d',
            'transaction_uuid' => '535a268fe05ef',
            'unsigned_field_names' => 'card_type,card_number,card_expiry_date',
            'signed_date_time' => '2014-04-25T09:10:39Z',
            'locale' => 'en',
            'transaction_type' => 'authorization',
            'reference_number' => '1398417042520',
            'amount' => '100.00',
            'currency' => 'USD',
            'payment_method' => 'card',
            'bill_to_forename' => 'John',
            'bill_to_surname' => 'Doe',
            'bill_to_email' => 'null@cybersource.com',
            'bill_to_phone' => '02890888888',
            'bill_to_address_line1' => '1 Card Lane',
            'bill_to_address_city' => 'My City',
            'bill_to_address_state' => 'CA',
            'bill_to_address_country' => 'US',
            'bill_to_address_postal_code' => '94043',
            'submit' => 'Submit'
    );
    public function __construct(){
        $this->securityHelper = new CyberSourceSecurityHelper(new HmacEncryptor());
    }
    public static function setUpBeforeClass(){
    }
    public static function tearDownAfterClass(){
    }
    public function setUp(){
    }
    public function tearDown(){
    }
    public function testSignData(){
        $param = array();
        $actual = $this->securityHelper->signData($param, CyberSourceSecurityHelperTest::SECRET_KEY);
        $this->assertSame('', $actual);

        $param = array(
                'signed_field_names' => 'xxx',
                'xxx' => 'abc'
        );
        $dataToSign = $this->securityHelper->buildDataToSign($param);
        $actual = $this->securityHelper->signData($dataToSign, '');
        $this->assertSame('', $actual);

        $param = array();
        $dataToSign = $this->securityHelper->buildDataToSign($param);
        $actual = $this->securityHelper->signData($dataToSign, '');
        $this->assertSame('', $actual);

        $param = array(
                'signed_field_names' => 'xxx',
                'xxx' => 'abc'
        );
        $dataToSign = $this->securityHelper->buildDataToSign($param);
        $actual = $this->securityHelper->signData($dataToSign, CyberSourceSecurityHelperTest::SECRET_KEY);
        $this->assertSame('XPySwJhTWNWVYmS9feT7xcTDmJdPtSYXyRs5rkPWRF0=', $actual);

        $dataToSign = $this->securityHelper->buildDataToSign($this->REAL_PARAMS);
        $actual = $this->securityHelper->signData($dataToSign, CyberSourceSecurityHelperTest::SECRET_KEY);
        $this->assertSame('xSfECF/y4Yb8iu0GNYXq4IMWMxxQqfn9jv8WNLGGSrY=', $actual);
    }
    public function testBuildDataToSign(){
        $param = array();
        $actual = $this->securityHelper->buildDataToSign($param);
        $this->assertSame('', $actual);

        $param = array(
                'signed_field_names' => 'xxx'
        );
        $actual = $this->securityHelper->buildDataToSign($param);
        $this->assertSame('', $actual);

        $param = array(
                'signed_field_names' => 'xxx',
                'xxx' => 'abc'
        );
        $expected = 'xxx=abc';
        $actual = $this->securityHelper->buildDataToSign($param);
        $this->assertSame($expected, $actual);

        $param = array(
                'signed_field_names' => 'xxx,yyy',
                'xxx' => 'abc',
                'yyy' => 'def'
        );
        $expected = 'xxx=abc,yyy=def';
        $actual = $this->securityHelper->buildDataToSign($param);
        $this->assertSame($expected, $actual);
    }
    public function testhasSignedFieldNames(){
        $param = NULL;
        $actual = $this->securityHelper->hasSignedFieldNames($param);
        $this->assertFalse($actual);

        $param = '';
        $actual = $this->securityHelper->hasSignedFieldNames($param);
        $this->assertFalse($actual);

        $param = array();
        $actual = $this->securityHelper->hasSignedFieldNames($param);
        $this->assertFalse($actual);

        $param = array(
                'key' => 'value'
        );
        $actual = $this->securityHelper->hasSignedFieldNames($param);
        $this->assertFalse($actual);

        $param = array(
                'signed_field_names' => ''
        );
        $actual = $this->securityHelper->hasSignedFieldNames($param);
        $this->assertFalse($actual);

        $param = array(
                'signed_field_names' => array(
                        'a'
                )
        );
        $actual = $this->securityHelper->hasSignedFieldNames($param);
        $this->assertFalse($actual);

        $param = array(
                'signed_field_names' => 'xxx'
        );
        $actual = $this->securityHelper->hasSignedFieldNames($param);
        $this->assertTrue($actual);
    }
    public function testSignWithInvalidArgument(){
        $param = '';
        $actual = $this->securityHelper->sign($param, CyberSourceSecurityHelperTest::SECRET_KEY);
        $this->assertSame('', $actual);

        $param = '';
        $actual = $this->securityHelper->sign($this->REAL_PARAMS, array());
        $this->assertSame('', $actual);

        $param = '';
        $actual = $this->securityHelper->sign($param, array());
        $this->assertSame('', $actual);
    }
    public function testSignWithValidArgument(){
        $actual = $this->securityHelper->sign($this->REAL_PARAMS, CyberSourceSecurityHelperTest::SECRET_KEY);
        $this->assertSame('xSfECF/y4Yb8iu0GNYXq4IMWMxxQqfn9jv8WNLGGSrY=', $actual);

    }
}
