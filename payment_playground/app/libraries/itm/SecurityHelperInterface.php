<?php

namespace itm;

interface SecurityHelperInterface{
    /**
     * Takes data to create the data signature
     *
     * @param mixed $dataToSign
     *            Data to be signed, can be a string, an array, or an object
     * @param string $secretKey
     *            A string key use to sign the data
     * @return string
     */
    public function sign($dataToSign, $secretKey);
}