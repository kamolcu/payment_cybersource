<?php

namespace itm;

interface StringEncryptorInterface{
    /**
     * Takes a string of data to encrypt and returns a string of encryted data.
     *
     * @param string $dataToEncrypt
     *            A string data to be encryped
     * @param string $key
     *            A key use to sign the data
     * @param boolean $rawOutputFlag
     *            A flag to tell the function to return raw output or not. Default is false.
     * @return string
     */
    public function encrypt($dataToEncrypt, $key, $rawOutputFlag = false);
}
