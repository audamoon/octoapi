<?php
require 'counter.php';

$OAuth_token = $_POST["token"];
$counter_id = $_POST["counter"];
if (empty($OAuth_token) || empty($counter_id)) {
    exit("Empty fields");
}

$domens_to_add = explode("\n",$_POST["domens"]);
$mirrors = get_mirrors($counter_id, $OAuth_token);

if (empty($domens_to_add)) {
    exit("Empty fields");
}

foreach ($domens_to_add as $domen) {
    if (!in_array($domen, $mirrors)) { 
        $mirrors[] = array("site" => $domen);
    }
};

//  $mirrors[] = array("site" => str_replace('\r','',$domen));

$data_json = array('counter' => array ('mirrors2'=>$mirrors, "mirrors_remove"=>0));

$ch = curl_init();

$url = "https://api-metrika.yandex.net/management/v1/counter/" . $counter_id;

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth ' . $OAuth_token ,"Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data_json));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($ch);

curl_close($ch);

echo $res;

?>