<?php
/**
 * Created by PhpStorm.
 * User: IErshov
 * Date: 09.12.2014
 * Time: 13:39
 */

class Emarsys_API_Connector {
    public function __construct()
    {

    }
    function get($username,$password,$env,$uri,$params=array()){
        $host = "https://$env.emarsys.net";
        $url = $host."/api/v2/".$uri;

        $url.=$this->paramsToString($params);

        $created  = date('Y-m-d').'T'.date('H:i:s').'Z';
        $nonce = substr(md5(uniqid('nonce_', true)),0,16);
        $passwordDigest = base64_encode(sha1($nonce . $created . $password));

        $header = array(
            "X-WSSE: UsernameToken Username=\"$username\", PasswordDigest=\"$passwordDigest\", Nonce=\"$nonce\", Created=\"$created\"",
            "Content-Type: application/json",
            "Content-Length: 0");// IF ITS GET Content-Length = 0

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);// You forgot to send the headers!
        curl_setopt($ch, CURLOPT_POST, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For Windows machines... some windows misses some CACERT.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return  $output = json_decode(curl_exec($ch));
    }

    function paramsToString($arr)
    {
        if(empty($arr)) return '';
        $str='?';
        foreach($arr as $key => $value)
        {
            $str.=$key.'='.$value.'&';
        }
        $str=preg_replace('/&$/','', $str);
        return $str;
    }

    public function post($username,$password,$env,$uri,$data_string){
        $host = "https://$env.emarsys.net";
        $url = $host."/api/v2/".$uri;

        $created  = date('Y-m-d').'T'.date('H:i:s').'Z';
        $nonce = substr(md5(uniqid('nonce_', true)),0,16);
        $passwordDigest = base64_encode(sha1($nonce . $created . $password));

        $header = array(
            "X-WSSE: UsernameToken Username=\"$username\", PasswordDigest=\"$passwordDigest\", Nonce=\"$nonce\", Created=\"$created\"",
            "Content-Type: application/json",
            "Content-Length: ".strlen($data_string));// IF ITS GET Content-Length = 0

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);// You forgot to send the headers!
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For Windows machines... some windows misses some CACERT.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return  $output = json_decode(curl_exec($ch));
    }

    public function put($username,$password,$env,$uri,$data_string){
        $host = "https://$env.emarsys.net";
        $url = $host."/api/v2/".$uri;
        $created  = date('Y-m-d').'T'.date('H:i:s').'Z';
        $nonce = substr(md5(uniqid('nonce_', true)),0,16);
        $passwordDigest = base64_encode(sha1($nonce . $created . $password));
        $header = array(
            "X-WSSE: UsernameToken Username=\"$username\", PasswordDigest=\"$passwordDigest\", Nonce=\"$nonce\", Created=\"$created\"",
            "Content-Type: application/json",
            "Content-Length: ".strlen($data_string));// IF ITS GET Content-Length = 0
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For Windows machines... some windows misses some CACERT.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = json_decode(curl_exec($ch));

        curl_close($ch);

        return $output;
    }

    function emarsys_delete($username,$password,$env,$uri,$data_string){

        return '';
    }
} 