<?php
define('HMAC_SHA256', 'sha256');
define('SECRET_KEY', '9d097228f0174a32a04fa7979602324697eed79a3b8c412bb8b5b20f5086c0f5945ceb5be4a141b8bc16bad43d70cd2162524d583a924c039248e9574ad293a44a4f8f0caf1a4927b0fc4f74611a7f769a02e8e3fd29447cb8eb50a8ce16dacfef1e06a9b6d34bfa94c1a8e53dd67922e01cb9cb89c04f1097989b40c25d9ff6');
function sign($params){
    return signData(buildDataToSign($params), SECRET_KEY);
}
function signData($data, $secretKey){
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}
function buildDataToSign($params){
    $signedFieldNames = explode(",", $params["signed_field_names"]);
    foreach($signedFieldNames as $field){
        $dataToSign[] = $field . "=" . $params[$field];
    }
    return commaSeparate($dataToSign);
}
function commaSeparate($dataToSign){
    return implode(",", $dataToSign);
}
