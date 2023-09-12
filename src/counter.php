<?php 

function get_mirrors($counter_id, $OAuth_token) {
    $ch = curl_init();

    $url = "https://api-metrika.yandex.net/management/v1/counter/" . $counter_id;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth ' . $OAuth_token ,"Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $counter = json_decode(curl_exec($ch),true);

    curl_close($ch);

    $mirrors = $counter["counter"]["mirrors2"];

    $mirrors_domens = [];

    if (empty($mirrors)){
        return [];
    }

    foreach ($mirrors as $value) {
        $mirrors_domens[] = ['site'=>$value['site']];
    }

    return $mirrors_domens;
}

?>