<?php
$data_json = file_get_contents("request.json");

$ch = curl_init();

$counter_id = "66051736";
$url = "https://api-metrika.yandex.net/management/v1/counter/" . $counter_id;

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth y0_AgAAAABD63-hAAppYAAAAADrbQODULGtsFMHQjSuq_chSpjfrrC1myk',"Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$res = curl_exec($ch);

curl_close($ch);

echo $res;

?>