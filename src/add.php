<?php
echo set_time_limit(0);

function get_request($url, $OAuth_token) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth ' . $OAuth_token ,"Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $res = curl_exec($ch);

    curl_close($ch);

    return $res;
}
function post_request($url, $OAuth_token, $data_json) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth ' . $OAuth_token ,"Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data_json));

    $res = curl_exec($ch);

    curl_close($ch);

    return $res;
}

$OAuth_token = $_POST["token"];

$get_user_id_url = "https://api.webmaster.yandex.net/v4/user";
$user_id = json_decode(get_request($get_user_id_url, $OAuth_token),1)["user_id"];

$add_domen = "https://api.webmaster.yandex.net/v4/user/" . $user_id . "/hosts";


// $domens = explode("\n",$_POST["domens"]);

// foreach ($domens as $domen) {
//     $to_json = ['host_url'=>$domen];
//     post_request($add_domen, $OAuth_token, $to_json);
//     sleep(1);
//     usleep(210000);
// }
$hosts = json_decode(get_request($add_domen, $OAuth_token),1)['hosts'];

foreach ($hosts as $host) {
    if ($host["verified"] == false) {
        $verification_link = "https://api.webmaster.yandex.net/v4/user/" . $user_id . "/hosts/" . $host["host_id"] ."/verification?verification_type=HTML_FILE";
        echo post_request($verification_link, $OAuth_token, "");
        sleep(1);
        usleep(210000);
    }
}
?>