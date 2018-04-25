<?php

function getMentions($text){
    $text = preg_replace('/@(\w+)/','<a href="/users/$1">@$1</a>',$text);
    $text = preg_replace('/#(\w+)/','<a href="/hashtag/$1">#$1</a>',$text);

    return strip_tags($text, "<a>");
}

function getHashtags($text){
    $text = preg_match_all('/#(\w+)/', $text, $matches);

    return $matches;
}

function hasRecaptcha(){
    if(Config::get("recaptcha.siteKey") and Config::get("recaptcha.secretKey")){
        return true;
    }

    return false;
}

function hasAnySocial(){
    if(Config::get("services.facebook.client_id") and Config::get("services.facebook.client_secret")){
        return true;
    }

    if(Config::get("services.twitter.client_id") and Config::get("services.twitter.client_secret")){
        return true;
    }

    if(Config::get("services.google.client_id") and Config::get("services.google.client_secret")){
        return true;
    }

    return false;
}

function hasSocial($social){
    if($social == "facebook"){
        if(Config::get("services.facebook.client_id") and Config::get("services.facebook.client_secret")){
            return true;
        }
    }

    if($social == "twitter"){
        if(Config::get("services.twitter.client_id") and Config::get("services.twitter.client_secret")){
            return true;
        }
    }

    if($social == "google"){
        if(Config::get("services.google.client_id") and Config::get("services.google.client_secret")){
            return true;
        }
    }

    return false;
}

function correct_size($photo) {
    $maxHeight = 350;
    $maxWidth = 600;
    list($width, $height) = getimagesize($photo);

    return ( ($width >= $maxWidth) && ($height >= $maxHeight) );
}

function nicetime($time){
    return localDate($time) . " " . trans("front.at") . " " . substr($time, 10, 6);
}

function startsWith($haystack, $needle){
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function smart_date($date){
    $cal_date = strtotime($date) - strtotime(date('Y-m-d H:i:s'));

    if($cal_date <= 86400 and $cal_date > -86400){
        return trans("front.today");
    }else{
        return localDate($date);
    }
}

function truncString($string, $length) {
    if (strlen($string) > $length) {
        $string = substr($string, 0, $length) . "...";
    }
    return $string;
}

function nice_date($date){
    $cal_date = strtotime(date('Y-m-d H:i:s')) - strtotime($date);
    if($cal_date < 86400){
        return substr($date, 11, 5);
    }else{
        return localDate($date);
    }
}

function noYear($timestamp){
    $daynum = date("d", strtotime($timestamp));
    $month  = date("F", strtotime($timestamp));

    switch($month)
    {
        case "January":   $month = trans("front.january");    break;
        case "February":  $month = trans("front.february");   break;
        case "March":     $month = trans("front.march");     break;
        case "April":     $month = trans("front.april");     break;
        case "May":       $month = trans("front.may");       break;
        case "June":      $month = trans("front.june");      break;
        case "July":      $month = trans("front.july");      break;
        case "August":    $month = trans("front.august");    break;
        case "September": $month = trans("front.september"); break;
        case "October":   $month = trans("front.october");   break;
        case "November":  $month = trans("front.november");  break;
        case "December":  $month = trans("front.december");  break;
        default:          $month = trans("front.unknown");   break;
    }

    return $daynum . " " . $month;
}

function localDate($timestamp){

    $daynum = date("d", strtotime($timestamp));
    $month  = date("F", strtotime($timestamp));
    $year   = date("Y", strtotime($timestamp));

    switch($month)
    {
        case "January":   $month = trans("front.january");    break;
        case "February":  $month = trans("front.february");   break;
        case "March":     $month = trans("front.march");     break;
        case "April":     $month = trans("front.april");     break;
        case "May":       $month = trans("front.may");       break;
        case "June":      $month = trans("front.june");      break;
        case "July":      $month = trans("front.july");      break;
        case "August":    $month = trans("front.august");    break;
        case "September": $month = trans("front.september"); break;
        case "October":   $month = trans("front.october");   break;
        case "November":  $month = trans("front.november");  break;
        case "December":  $month = trans("front.december");  break;
        default:          $month = trans("front.unknown");   break;
    }

    return $daynum . " " . $month . " " . $year;
}

function is_empty($value){
    $var = empty($value);
    if($var) return true;

    return false;
}