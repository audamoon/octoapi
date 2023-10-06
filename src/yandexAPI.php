<?php

require_once '../vendor/autoload.php';


class YandexWebmaster
{
    private $httpclient;
    private $post_data;

    public function __construct($post_data)
    {
        $this->httpclient = new GuzzleHttp\Client(['base_uri' => 'https://api.webmaster.yandex.net/v4/']);
        $this->post_data = $post_data;
    }

    private function getHeader()
    {
        return [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->post_data['token'],
                'Content-Type' => 'application/json'
            ]
        ];
    }

    private function getUser()
    {
        $uri = 'user';
        $options = $this->getHeader();
        $res = $this->httpclient->get($uri, $options);

        return json_decode($res->getBody()->getContents(), 1)["user_id"];
    }

    private function getHosts()
    {
        $uri = 'user/' . $this->getUser() . "/hosts";
        $options = $this->getHeader();
        $res = $this->httpclient->get($uri, $options);

        return json_decode($res->getBody()->getContents(), 1)["hosts"];
    }

    public function addDomens()
    {
        set_time_limit(0);
        $uri = 'user/' . $this->getUser() . "/hosts";
        $domens = explode("\n", $_POST["domens"]);
        $unlink_domens = [];

        foreach ($domens as $domen) {
            $hosts = array_column($this->getHosts(), "unicode_host_url");
            $domen = trim($domen);

            if (!in_array($domen . '/', $hosts)) {
                array_push($unlink_domens, $domen);
            }
        }
        if (empty($unlink_domens)) {
            echo "nothing to add";
            return null;
        }

        foreach ($unlink_domens as $domen) {
            $body = [
                'json' =>
                [
                    'host_url' => $domen
                ]
            ];
            $options = $this->getHeader() + $body;

            $res = $this->httpclient->post($uri, $options);
            print_r($res);
            sleep(1);
            usleep(210000);
        }

        return $res;
    }

    private function verifyDomen($host_id)
    {
        $uri = 'user/' . $this->getUser() . '/hosts/' . $host_id . "/verification?verification_type=HTML_FILE";
        $options = $this->getHeader();

        $res = $this->httpclient->post($uri, $options);

        return $res;
    }

    public function domensVerification()
    {
        set_time_limit(0);
        $hosts = $this->getHosts();
        $unverified_host = [];

        foreach ($hosts as $host) {
            if ($host['verified'] == false) {
                array_push($unverified_host, $host["host_id"]);
            }
        }

        if (empty($unverified_host)) {
            echo "nothing to verify";
            return null;
        }

        foreach ($unverified_host as $host) {
            $res = $this->verifyDomen($host);
            sleep(1);
            usleep(210000);
        }
        return $res;
    }
}

class YandexMetrika
{
    private $httpclient;
    private $post_data;

    public function __construct($post_data)
    {
        $this->httpclient = new GuzzleHttp\Client(['base_uri' => 'https://api-metrika.yandex.net/management/v1/']);
        $this->post_data = $post_data;
    }

    private function getHeader()
    {
        return [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->post_data['token'],
                'Content-Type' => 'application/json'
            ]
        ];
    }

    private function getMirrors()
    {
        $uri = 'counter/' . $this->post_data['counter'];
        $options = $this->getHeader();

        $res = $this->httpclient->get($uri, $options);

        $json_res = json_decode($res->getBody()->getContents(), 1)['counter'];

        $mirrors = array_key_exists('mirrors2', $json_res) ? $json_res['mirrors2'] : [];

        if (!empty($mirrors)) {
            $mirrors_copy = $mirrors;
            $mirrors = [];
            foreach ($mirrors_copy as $mirror) {
                $mirrors[] = ['site' => $mirror['site']];
            }
        }

        return $mirrors;
    }

    public function addDomens()
    {
        $domens = explode("\n", $this->post_data['domens']);
        $mirrors = $this->getMirrors();

        foreach ($domens as $domen) {
            $domen = trim($domen);
            if (!in_array(['site' => $domen], $mirrors)) {
                $mirrors[] = ['site' => $domen];
            }
        }

        $body = [
            'json' => [
                'counter' => [
                    'mirrors2' => $mirrors
                ]
            ]
        ];

        $uri = 'counter/' . $this->post_data['counter'];
        $options = $this->getHeader() + $body;

        $res = $this->httpclient->put($uri, $options);

        return $res;
    }
}

class YandexController
{
    private $post_data;
    private $api;

    public function __construct($post_data)
    {
        $this->post_data = $post_data;
    }

    private function chooseAPI()
    {
        $page_api = explode('/', $this->post_data['page_url'])[1];

        switch ($page_api) {
            case ('metrika'):
                $this->api = new YandexMetrika($this->post_data);
                break;
            case ('webmaster'):
                $this->api = new YandexWebmaster($this->post_data);
                break;
        }
    }

    public function executeMethod()
    {
        $this->chooseAPI();

        $page_api_method = explode('/', $this->post_data['page_url'])[2];
        switch (true) {
            case ($this->api instanceof YandexMetrika):
                switch ($page_api_method) {
                    case ('add.php'):
                        return $this->api->addDomens();
                        break;
                }
                break;
            case ($this->api instanceof YandexWebmaster):
                switch ($page_api_method) {
                    case ('add.php'):
                        return $this->api->addDomens();
                        break;
                    case ('verify.php'):
                        return $this->api->domensVerification();
                        break;
                }
                break;
        }
    }
}
$yandex = new YandexController($_POST);
$res = $yandex->executeMethod();
print_r($res);
