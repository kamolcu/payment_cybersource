<?php

namespace itm;

use \itm\SecurityHelperInterface;
use \itm\StringEncryptorInterface;

class CyberSourceSecurityHelper implements SecurityHelperInterface{
    private $encryptor;
    const USE_RAW_OUTPUT = true;
    public function __construct(StringEncryptorInterface $encryptor){
        $this->encryptor = $encryptor;
    }
    public function hasSignedFieldNames($param){
        $output = false;
        if(is_array($param) && !empty($param['signed_field_names']) && is_string($param['signed_field_names'])){
            return true;
        }
        return $output;
    }
    public function buildDataToSign($param){
        if($this->hasSignedFieldNames($param)){
            $signedFieldNames = explode(",", $param["signed_field_names"]);
            $dataToSign = array();
            foreach($signedFieldNames as $field){
                if(isset($param[$field])){
                    $dataToSign[] = $field . "=" . $param[$field];
                }
            }
            return $this->commaSeparate($dataToSign);
        }else{
            return '';
        }
    }
    public function signData($dataToSign, $secretKey){
        return base64_encode($this->encryptor->encrypt($dataToSign, $secretKey, CyberSourceSecurityHelper::USE_RAW_OUTPUT));
    }
    public function sign($dataToSign, $secretKey){
        return $this->signData($this->buildDataToSign($dataToSign), $secretKey);
    }
    private static function commaSeparate($dataToSign){
        return implode(",", $dataToSign);
    }
}