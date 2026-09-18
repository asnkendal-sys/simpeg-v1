<?php
  namespace App\Traits;

  /**
   *
   */
  trait ApiBknAuth
  {
      private $access_token;
      private $expires_in;
      public function handleAuth()
      {
          $endpoint = config('bkn.base_url_auth');
          $client = new \GuzzleHttp\Client(['verify' =>false]);
          $response = $client->request(
              'POST',
              $endpoint,
              [
                'auth' => [env("CLIENT_ID"), env("BKN_PASSWORD")],
                'form_params' => [
                 'client_id' => env("CLIENT_ID"),
                'grant_type' => env("GRANT_TYPE")
                ],
    ]
          );
          $body = json_decode($response->getBody(), true);
          $this->access_token = $body["access_token"];
          $this->expires_in = $body["expires_in"];
          $this->setToSession();
          return $body;
      }
      public function getToken()
      {
          if (!\Session::has("access_token")) {
              $this->handleAuth();
          }
          if ($this->expires_in == 0) {
              $this->handleAuth();
          }
          return \Session::get("access_token");
      }

      private function setToSession()
      {
          if (!\Session::has("access_token") && !\Session::has("expires_in")) {
              \Session::put("access_token", $this->access_token);
          }
      }
  }
