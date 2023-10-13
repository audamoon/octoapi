<?php

require_once '../src/FormSanitizer.php';
require_once '../src/YandexAPI.php';

class ResponseController
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
                        return $this->api->verificationDomens();
                        break;
                    case ('delete.php'):
                        return $this->api->deleteDomens();
                        break;
                }
                break;
        }
    }
}


$sanitizer = new FormSanitizer($_POST);
$yandex = new ResponseController($sanitizer->getSanitizeData());
$res = $yandex->executeMethod();
print_r($res);