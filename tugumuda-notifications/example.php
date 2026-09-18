<?php
  session_start();
  require 'vendor/autoload.php';
  use Tugumuda\Notifications\Notification;
  use Tugumuda\Notifications\Access;

  $receipent=['ct8U1dt_Lzmstm4xC-W1oe:APA91bHI8JvGdeauYaGWyKDLEt8_0yBha9SjmaBiEPPdKDnUu9UgKctJ-qbNYqIFS28PuVSzbpsBkc3duXuntBrO80onDF-22Oh8rRAYvY-Qd6LAozkvtBGTWHpOTllCl9yvbijy_X9q', 'ct8U1dt_Lzmstm4xC-W1oe:APA91bHI8JvGdeauYaGWyKDLEt8_0yBha9SjmaBiEPPdKDnUu9UgKctJ-qbNYqIFS28PuVSzbpsBkc3duXuntBrO80onDF-22Oh8rRAYvY-Qd6LAozkvtBGTWHpOTllCl9yvbijy_X9q'];
  $notif = (new Notification())->api('POST', 'http://devel.dinustek.com:8073/e-cuti-cilacap-rest/api/v1/notification')
          ->withBody(['fcm_token'=> $receipent,'title' => 'title', 'body' =>'body'])
          ->send();

  $verif = (new Notification())->api('PATCH', 'http://devel.dinustek.com:8073/e-cuti-cilacap-rest/api/v1/cuti-usulan/7/verify/atasan')
           ->withBody(['alasan'=> 'test alasan'])
           ->send();

echo json_encode($notif);
$credentials =[
              'username' => 'sutrisno',
              'password' => 'sutrisno',
              'auth_from' => 'web-admin'
            ];
 $auth = (new Access())->api('POST', 'http://devel.dinustek.com:8073/e-cuti-cilacap-rest/api/v1/auth/login')->setCredentials($credentials)->auth();
 $_SESSION['access_token'] = $auth->access_token;

 //
 // remove token
 //$revokeToken =  (new Access())->api('POST', 'http://devel.dinustek.com:8073/e-cuti-cilacap-rest/api/v1/auth/logout')->revokeToken($_SESSION['access_token']);
