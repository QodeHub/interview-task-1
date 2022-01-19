<?php

include_once 'Data/Query.php';

class Shortener extends Query
{
    protected static $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
    protected static $checkUrlExists = true;
    protected static $codeLength = 5;

//    convert url to short code
    public function urlToShortCode($url){
        if(empty($url)){
            return $this->message("No URL was supplied.", true);
        }

        if($this->validateUrlFormat($url) == false){
            return $this->message("URL does not have a valid format.", true);
        }

        if(self::$checkUrlExists){
            if (!$this->verifyUrlExists($url)){
                return $this->message("URL does not appear to exist.", true);
            }
        }

        $shortCode = $this->urlExistsInDB($url);
        if($shortCode == false){
            $shortCode = $this->createShortCode($url);
        }

        return 'https://xyz.com/?c='.$shortCode;
    }

    protected function validateUrlFormat($url){
        try {
            return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOSTNAME);
        }catch (Exception $exception){
            return false;
        }
    }

//    verify url is valid
    protected function verifyUrlExists($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

//    create short code
    protected function createShortCode($url){
        $shortCode = $this->generateRandomString(self::$codeLength);
        $id = $this->insertUrlInDB($url, $shortCode);
        return $shortCode;
    }

    protected function generateRandomString($length = 6){
        $sets = explode('|', self::$chars);
        $all = '';
        $randString = '';
        foreach($sets as $set){
            $randString .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++){
            $randString .= $all[array_rand($all)];
        }
        $randString = str_shuffle($randString);
        return $randString;
    }

//    short code to url
    public function shortCodeToUrl($code, $increment = true){
        if(empty($code)) {
            return $this->message("No short code was supplied.", true);
        }

        if($this->validateShortCode($code) == false){
            return $this->message("Short code does not have a valid format.", true);
        }

        $urlRow = $this->getUrlFromDB($code);
        if(empty($urlRow)){
            return $this->message("Short code does not appear to exist.", true);
        }

        if($increment == true){
            $this->incrementCounter($urlRow["id"]);
        }

        return $urlRow["original_url"];
    }

//    validate short code
    protected function validateShortCode($code){
        $rawChars = str_replace('|', '', self::$chars);
        return preg_match("|[".$rawChars."]+|", $code);
    }
}