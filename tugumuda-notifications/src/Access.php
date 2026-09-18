<?php
namespace Tugumuda\Notifications;

class Access extends Base
{
    protected $credentials;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['verify' => false]);
    }

    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
        return $this;
    }

    public function auth()
    {
        $headers = [
       'Content-Type'  =>  'application/x-www-form-urlencoded',
       'Accept' => 'application/json'
    ];
        $result = [];
        try {
            $response = $this->client->request($this->method, $this->url, [
           'headers' => $headers,
           'form_params' =>  $this->credentials
      ]);
            $result= json_decode($response->getBody(), true);
            $result = $result['data']['attributes'];
            $result['status'] = 200;
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $response = $ex->getResponse();
            $result["status"] = $ex->getCode();
            print_r($ex->getMessage());

            $result["message"]  =  "invalid token";
        } catch (\Exception $e) {
            $result["message"]  = $e->getMessage();
        }

        return (object)$result;
    }

    public function revokeToken($token)
    {
        $headers = [
       'Authorization' => "Bearer $token",
       'Accept' => 'application/json'
    ];
        $result = [];
        try {
            $response = $this->client->request($this->method, $this->url, [
          'headers' => $headers,
      ]);
            $result= json_decode($response->getBody(), true);
            // $result = $result['data']['attributes'];
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $response = $ex->getResponse();
            $result["code"] = $ex->getCode();
            print_r($ex->getMessage());

            $result["message"]  =  "invalid token";
        } catch (\Exception $e) {
            $result["message"]  = $e->getMessage();
        }

        return (object)$result;
    }
}
