<?php
  namespace App\Repositories;

  class BaseRepository 
  {
      use \App\Traits\ApiBknAuth;
      protected $value;
      protected $baseUrl;
      protected $unwrap;
      protected $path;
      private $client;
      protected $endpoint;

      public function __construct()
      {
          $this->baseUrl = config('bkn.base_url_resource');
          $this->client = new \GuzzleHttp\Client(['verify' => false]);
      }

      protected function dataMapper($data)
      {
        try{
           if(!empty($this->unwrap))
          {
           foreach($this->unwrap as  $value)
           {
               $data = is_string($data[$value])?json_decode($data[$value], true):$data[$value];
            }
          }
        }catch(\Exception $ex){
          $data = $data;
        }
         
          return $data;
      }

      public function apiPath($path)
      {
          $this->path = $path;
          return $this;
      }

      public function baseUrl($url)
      {
          $this->baseUrl = $url;
          return $this;
      }

      public function endpoint($endpoint)
      {
          $this->endpoint = $endpoint;
          return $this;
      }

      public function fetch($nip)
      {
        $endpoint = $this->endpoint ?: $this->baseUrl.$this->path.'/'.$nip;
        $headers = [
           'Authorization' => 'Bearer' . $this->getToken(),
           'Content-Type'  => 'application/json',
        ];

          $result = [];
          try {
              $response = $this->client->request('GET', $endpoint, [
              'headers' => $headers,
              ['debug' => true]

          ]);

              $result= json_decode($response->getBody(), true);
          } catch (\GuzzleHttp\Exception\ClientException $ex) {
              $response = $ex->getResponse();
              $result["code"] = $ex->getCode();
              \Log::error($ex->getMessage());
              $result["message"]  =  "invalid token";
          } catch (\Exception $e) {
              \Log::error($e);
              $result["message"]  = $e->getMessage();
          }
          return  $this->dataMapper($result);
      }

      public function store($data)
      {
          $endpoint = $this->endpoint ?: $this->baseUrl.$this->path;
          $headers = [
           'Authorization' => 'Bearer' . $this->getToken(),
           'Content-Type'  => 'application/json',
        ];
          $result = [];
          try {
              $response = $this->client->request('POST', $endpoint, [
              'headers' => $headers,
              'json' =>  $data,
            ]);
              $body=json_decode($response->getBody(), true);
              $result= is_string($body)?json_decode($body, true):$body;
          } catch (\Exception $e) {
              \Log::error($e->getMessage());
              $result["message"]  = $e->getMessage();
          }

          return  $result;
      }
  }
