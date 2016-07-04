<?php

namespace ready2order;

/**
 * PHP library for ready2order POS API v1
 * @author Christopher Fuchs <developer@ready2order.at>
 *
 * Thanks to Drew McLellan for creating drewm/mailchimp-api (https://github.com/drewm/mailchimp-api)
 * This PHP library was written by Dew McLellan and "forked" for using ready2order API because it's just super simple
 * @author Drew McLellan <drew.mclellan@gmail.com>
 */
class ready2orderAPI
{
    private $api_key;
    private $api_endpoint = 'https://api.ready2order.at/v1';
    
    /*  SSL Verification
        Read before disabling: 
        http://snippets.webaware.com.au/howto/stop-turning-off-curlopt_ssl_verifypeer-and-fix-your-php-config/
    */
    public  $verify_ssl   = true; 

    /**
     * Create a new instance
     * @param string $api_key Your ready2order API key
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }
    
    public function delete($method, $args=array(), $timeout=10)
    {
        return $this->makeRequest('delete', $method, $args, $timeout);
    }

    public function get($method, $args=array(), $timeout=10)
    {
        return $this->makeRequest('get', $method, $args, $timeout);
    }

    public function patch($method, $args=array(), $timeout=10)
    {
        return $this->makeRequest('patch', $method, $args, $timeout);
    }

    public function post($method, $args=array(), $timeout=10)
    {
        return $this->makeRequest('post', $method, $args, $timeout);
    }

    public function put($method, $args=array(), $timeout=10)
    {
        return $this->makeRequest('put', $method, $args, $timeout);
    }

    /**
     * Performs the underlying HTTP request. Not very exciting
     * @param  string $$http_verb   The HTTP verb to use: get, post, put, patch, delete
     * @param  string $method       The API method to be called
     * @param  array  $args         Assoc array of parameters to be passed
     * @return array                Assoc array of decoded result
     */
    private function makeRequest($http_verb, $method, $args=array(), $timeout=10)
    {
        $url = $this->api_endpoint.'/'.$method;

        $json_data = json_encode($args, JSON_FORCE_OBJECT);
        if (function_exists('curl_init') && function_exists('curl_setopt')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json',
                                                        'Content-Type: application/json',
                                                        'Authorization: '.$this->api_key));
            curl_setopt($ch, CURLOPT_USERAGENT, 'duxthefux/ready2order-php-api-v1 (github.com/duxthefux/ready2order-php-api-v1)');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($ch, CURLOPT_ENCODING, '');

            switch($http_verb) {
                case 'post':
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
                    break;

                case 'get':
                    $query = http_build_query($args);
                    curl_setopt($ch, CURLOPT_URL, $url.'?'.$query);
                    break;

                case 'delete':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    break;

                case 'patch':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
                    break;
                
                case 'put':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
                    break;
            }


            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            throw new \Exception("cURL support is required, but can't be found.");
        }

        if(!is_null($json = json_decode($result, true))){

//            if(!isset($json["error"]) || $json["error"]==false) return $json;

            if(isset($json["error"]) && $json["error"]===true) {
                $msg = isset($json["msg"]) && !empty($json["msg"]) ? $json["msg"] : $result;
                throw new ready2orderErrorException($msg);
            }

            return $json;
//            if(!$json["error"] && isset($json["msg"])) throw new ready2orderException($json["msg"]);
//            else throw new ready2orderException("API Request was bad: ".$result);
        } else {
            throw new ready2orderException("API Request gave invalid json: ".$result);
        }
    }

    /**
     * @param string $api_endpoint
     */
    public function setApiEndpoint($api_endpoint)
    {
        $this->api_endpoint = $api_endpoint;
    }



}
