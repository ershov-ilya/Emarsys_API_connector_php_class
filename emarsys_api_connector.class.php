<?php
/**
 * Created by PhpStorm.
 * User: IErshov
 * Date: 09.12.2014
 * Time: 13:39
 */

class Emarsys_API_Connector {
    private $config,$username,$password,$api_url;

    public function __construct($campaign, $pathToConfig='config/')
    {
        require($pathToConfig.'api.config.php');
        $this->config=getConfig($campaign);
        $this->username=$this->config['username'];
        $this->password=$this->config['secret'];
        $this->api_url=$this->config['suiteApiUrl'];
    }

    public function test()
    {
        //header('Content-Type: text/plain; charset=utf-8');

        //print_r($this->get('event'));

        /*
        $list=array("a_s_w_4@mail.ru", "irishapo@gmail.com");
        $params = array("keyId" => "3", "keyValues" => $list, "fields"=>array("1","2","3","31"));
        $data_string = json_encode($params);
        print_r($this->post("contact/getdata", $data_string));
        /**/
    }

    /** @return stdClass */
    function get($uri,$params=array()){
        $url = $this->api_url.$uri;
        $username=$this->username;
        $password=$this->password;

        $url.=$this->paramsToString($params);

        $created  = date('Y-m-d').'T'.date('H:i:s').'Z';
        $nonce = substr(md5(uniqid('nonce_', true)),0,16);
        $passwordDigest = base64_encode(sha1($nonce . $created . $password));

        $header = array(
            "X-WSSE: UsernameToken Username=\"$username\", PasswordDigest=\"$passwordDigest\", Nonce=\"$nonce\", Created=\"$created\"",
            "Content-Type: application/json",
            "Content-Length: 0");// IF ITS GET Content-Length = 0

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For Windows machines... some windows misses some CACERT.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return  $output = json_decode(curl_exec($ch));
    }

    /** @return stdClass */
    public function post($uri,$data_string){
        $url = $this->api_url.$uri;
        $username=$this->username;
        $password=$this->password;

        $created  = date('Y-m-d').'T'.date('H:i:s').'Z';
        $nonce = substr(md5(uniqid('nonce_', true)),0,16);
        $passwordDigest = base64_encode(sha1($nonce . $created . $password));

        $header = array(
            "X-WSSE: UsernameToken Username=\"$username\", PasswordDigest=\"$passwordDigest\", Nonce=\"$nonce\", Created=\"$created\"",
            "Content-Type: application/json",
            "Content-Length: ".strlen($data_string));// IF ITS GET Content-Length = 0

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For Windows machines... some windows misses some CACERT.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return  $output = json_decode(curl_exec($ch));
    }

    /** @return stdClass */
    public function put($uri,$data_string){
        $url = $this->api_url.$uri;
        $username=$this->username;
        $password=$this->password;

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

    function emarsys_delete($uri,$data_string){
        $url = $this->api_url.$uri;
        $username=$this->username;
        $password=$this->password;

        return '';
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

}