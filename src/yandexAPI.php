<?php
require_once '../vendor/autoload.php';


class YandexWebmaster
{
    private $httpclient;
    private $sanitize_data;

    public function __construct($sanitize_data)
    {
        $this->httpclient = new GuzzleHttp\Client(['base_uri' => 'https://api.webmaster.yandex.net/v4/']);
        $this->sanitize_data = $sanitize_data;
    }

    private function getHeader()
    {
        return [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->sanitize_data['token'],
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
        $domens = $this->sanitize_data["domens"];
        $unlink_domens = [];

        foreach ($domens as $domen) {
            $hosts = array_column($this->getHosts(), "host_id");

            if (!in_array($domen, $hosts)) {
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
                    'host_url' => str_replace(["http:", "https:", ":80", ":443"], ["http://", "https://", "", ""], $domen)
                ]
            ];

            $options = $this->getHeader() + $body;

            $res = $this->httpclient->post($uri, $options);
            print_r($res);
            sleep(1);
            usleep(210000);
        }

        return $res->getStatusCode();
    }

    private function verifyDomen($host_id)
    {
        $uri = 'user/' . $this->getUser() . '/hosts/' . $host_id . "/verification?verification_type=HTML_FILE";
        $options = $this->getHeader();

        $res = $this->httpclient->post($uri, $options);

        return $res;
    }

    public function verificationDomens()
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
        return $res->getStatusCode();
    }

    public function deleteDomen($delete_host_id)
    {
        $uri = 'user/' . $this->getUser() . '/hosts/' . $delete_host_id;
        $options = $this->getHeader();

        $res = $this->httpclient->delete($uri, $options);

        return $res;
    }

    public function deleteDomens()
    {
        set_time_limit(0);
        $domens = $this->sanitize_data["domens"];

        foreach ($domens as $domen) {
            $hosts = array_column($this->getHosts(), "host_id");

            if (!in_array($domen, $hosts)) {
                array_diff($domens, [$domen]);
            }
        }

        foreach ($domens as $domen) {

            $res = $this->deleteDomen($domen);
            sleep(1);
            usleep(210000);
        }

        return $res;
    }
}

class YandexMetrika
{
    private $httpclient;
    private $sanitize_data;

    public function __construct($sanitize_data)
    {
        $this->httpclient = new GuzzleHttp\Client(['base_uri' => 'https://api-metrika.yandex.net/management/v1/']);
        $this->sanitize_data = $sanitize_data;
    }

    private function getHeader()
    {
        return [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->sanitize_data['token'],
                'Content-Type' => 'application/json'
            ]
        ];
    }

    private function getMirrors()
    {
        $uri = 'counter/' . $this->sanitize_data['counter'];
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
        $domens = $this->sanitize_data['domens'];
        $mirrors = $this->getMirrors();

        foreach ($domens as $domen) {
            $domen = str_replace(["https:", "http:", ":443", ":80"], '', $domen);
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

        $uri = 'counter/' . $this->sanitize_data['counter'];
        $options = $this->getHeader() + $body;

        $res = $this->httpclient->put($uri, $options);

        return $res;
    }
}
