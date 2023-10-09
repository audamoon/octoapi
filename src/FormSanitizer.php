<?php


class FormSanitizer
{
    private $post_data;
    private $saniitize_data;

    const MATCH_URL = "/(((http|https):\/\/)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6})/";

    public function __construct($post_data)
    {
        $this->post_data = $post_data;
    }

    public function getSanitizeData()
    {
        $this->getHostIDs();

        if (!empty($this->post_data["token"])) {
            $this->saniitize_data["token"] = $this->post_data["token"];
        }
        if (!empty($this->post_data["counter"])) {
            $this->saniitize_data["counter"] = $this->post_data["counter"];
        }
        if (!empty($this->post_data["page_url"])) {
            $this->saniitize_data["page_url"] = $this->post_data["page_url"];
        }

        return $this->saniitize_data;
    }

    private function sanitizeStr($string)
    {
        return strip_tags(htmlspecialchars($string));
    }

    private function createHostID($domen)
    {
        if (preg_match($this::MATCH_URL, $domen) == 1) {
            switch (true) {
                case (str_contains($domen, "https://")):
                    return str_replace("//", "", $domen) . ":443";
                    break;
                case ((str_contains($domen, "http://"))):
                    return str_replace("//", "", $domen) . ":80";
                    break;
            }
        } else {
            return "";
        }
    }

    private function getHostIDs()
    {
        if (empty($this->post_data["domens"])) {
            http_response_code(410);
        }

        $domens = $this->sanitizeStr($this->post_data["domens"]);

        $domens = preg_split('/\r?\s/', $this->post_data["domens"]);
        $domens = array_map("FormSanitizer::createHostID", $domens);
        $domens = array_diff($domens, [""]);

        if (empty($domens)) {
            http_response_code(400);
        }

        $this->saniitize_data["domens"] = $domens;
    }
}