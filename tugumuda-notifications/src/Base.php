<?php
  namespace Tugumuda\Notifications;

  class Base
  {
      protected $url;

      protected $method;

      /**
       * set api
       * @param  string $url
       */
      public function Api($method, $url)
      {
          $this->method= $method;
          $this->url = $url;
          return $this;
      }
  }
