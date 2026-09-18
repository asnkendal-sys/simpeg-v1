<?php
  namespace Tugumuda\Notifications;

  class Notification extends Base
  {
      protected $notif;
      // protected $recipient;
      protected $body;

      public function __construct()
      {
          $this->client = new \GuzzleHttp\Client(['verify' => true]);
      }

      /**
       *  set body
       * @param  array $body
       *
       */
      public function withBody($body)
      {
          $this->body = $body;
          return $this;
      }


      public function send()
      {
          $result = [];
          try {
              $response = $this->client->request($this->method, $this->url, $this->clientRequestOptions());
              $result= json_decode($response->getBody(), true);
              $result['status'] = 200;
          } catch (\GuzzleHttp\Exception\ClientException $ex) {
              $result["code"] = $ex->getCode();
              $result["message"]  =  $ex->getMessage();
          } catch (\Exception $e) {
              $result["message"]  = $e->getMessage();
          }

          return (object)$result;
      }


      private function clientRequestOptions()
      {
          $options = [
          'headers' => [
            'Authorization' => isset($_SESSION['access_token'])?'Bearer '.$_SESSION['access_token']:'',
            'Accept' => 'application/json'
          ],

      ];

          if (!empty($this->body)) {
              $options['form_params'] = $this->body;
          }
          return $options;
      }
  }
