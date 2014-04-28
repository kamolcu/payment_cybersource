<?php

namespace itm;

use itm\StringEncryptorInterface;

class HmacEncryptor implements StringEncryptorInterface{
    Const DEFAULT_ALGO = 'sha256';
    private $algo;
    public function __construct($algo = NULL){
        if(!empty($algo)){
            $this->algo = $algo;
        }else{
            $this->algo = $this::DEFAULT_ALGO;
        }
    }
    public function encrypt($dataToEncrypt, $key, $rawOutputFlag = false){
        if(empty($dataToEncrypt) || !is_string($dataToEncrypt) || empty($key) || !is_string($key) || !is_bool($rawOutputFlag)){
            return '';
        }
        return hash_hmac($this->algo, $dataToEncrypt, $key, $rawOutputFlag);
    }
    public function getCurrentAlgo(){
        return $this->algo;
    }
}