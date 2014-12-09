<?php
/**
 * Created by PhpStorm.
 * User: IErshov
 * Date: 05.11.2014
 * Time: 19:02
 */


function getConfig($key = null) {
    $campaign1['username'] = "login";
    $campaign1['secret'] = "password";
    $campaign1['suiteApiUrl'] = "http://suite7.emarsys.net/api/v2/";

    $campaign2['username'] = "login";
    $campaign2['secret'] = "password";
    $campaign2['suiteApiUrl'] = "http://suite7.emarsys.net/api/v2/";

    $campaign3['username'] = "login";
    $campaign3['secret'] = "password";
    $campaign3['suiteApiUrl'] = "http://suite7.emarsys.net/api/v2/";

    $campaign4['username'] = "login";
    $campaign4['secret'] = "password";
    $campaign4['suiteApiUrl'] = "http://suite7.emarsys.net/api/v2/";


    $result = array(
        'campaign1' => $campaign1,
        'campaign2' => $campaign2,
        'campaign3' => $campaign3,
        'campaign4' => $campaign4
    );

    if($key==null) return $result;
    else return $$key;
}

$apiconfig = getConfig();
