<?php
require_once('../config/config.php');
function otpsender($mobile,$conn) {

    $query = "DELETE FROM opt WHERE created_at < NOW() - INTERVAL 2 HOUR";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $opt = rand(1000, 9999);

    $query = "INSERT INTO opt (mobile, opt) VALUES (:mobile, :opt)";
    $stmt = $conn->prepare($query);
    $stmt->bindvalue(":mobile",$mobile);
    $stmt->bindvalue(":opt",$opt);
    $stmt->execute();

    $curl = curl_init();
    $apikey = '';
    $message = urlencode("Your verification code is: $opt");
    $sender = '100090003';
    $url = "https://api.kavenegar.com/v1/$apikey/sms/send.json?receptor=$mobile&sender=$sender&message=$message";


    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'Cookie: cookiesession1=678A8C40E277BD0A60A9819053EC3D82'
    ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return $httpcode;
}
?>