<?php
namespace App\Repositories;
use App\Models\Riwayat\LogBSRE;
use Auth;
 /**
  *
  */
 class BsreApiRepository
 {
     public function signDocument($form_data, $transaction_id = '')
     {
        //  $endpoint = "103.162.68.99/api/sign/pdf"; 
		$endpoint = env('API_BSRE_BASE_URI')."/sign/pdf"; 
        // echo $endpoint; exit();
       // $credentials = base64_encode('ekgb_bkpp:e-KGB_@23');
         //08072026
        $credentials = base64_encode('ekgbbkpsdm:S1mp39@KGB');
 //  $credentials = base64_encode('ekgb_bkpp:e-KGB_@23');
         $headers = [
            'Authorization' => "Basic {$credentials}",

         ];
         
         $client = new \GuzzleHttp\Client(['verify' => false]);
         $result = [];
         $response = "";
         try {
             $response = $client->request('POST', "{$endpoint}", [
                'multipart' => $form_data,
                'headers' => $headers,
                ['debug' => true]
            ]);

             $result["code"] = "200";
             $result["message"] = "success";
             $result["message_log"] = "success";
             $result["data"]["id_dokumen"] = $response->getHeaders()["id_dokumen"][0];
         } catch (\GuzzleHttp\Exception\ClientException $ex) {
             $result["code"] = $ex->getCode();
             $result["message_log"] = $ex->getResponseBodySummary($ex->getResponse());
             
             \Log::error($ex->getMessage());
             $message  = $ex->getMessage();
             $message = substr($message, strpos($message, '{'), strrpos($message, '}')-strpos($message, '{')+1);
             $message = @json_decode($message, true)['error'];
             $result["message"] = $message;
         }

         $this->addLog($transaction_id, $form_data, $endpoint, $result['code'],$result['message_log']);
         
         return $result;
     }

     public function downlodDocument($id_dokumen)
     {
         $endpoint = env('API_BSRE_BASE_URI')."/sign/download/{$id_dokumen}";
         //$credentials = base64_encode('ekgb_bkpp:e-KGB_@23');
  //08072026
        $credentials = base64_encode('ekgbbkpsdm:S1mp39@KGB');         
$headers = [
              'Authorization' => "Basic {$credentials}",
           ];

         $client = new \GuzzleHttp\Client(['verify' => false]);
         $result = [];
         try {
             $response = $client->request('GET', "{$endpoint}", [
             'sink' => storage_path("app/sign/file-{$id_dokumen}-sign.pdf"),

               'headers' => $headers,
               ['debug' => true]
           ]);


             $result["code"] = "200";
             $result["message"] = "success";
         } catch (\GuzzleHttp\Exception\ClientException $ex) {
             $response = $ex->getResponse();
             $result["code"] = $ex->getCode();
             $body = $response->getBody();

             \Log::error($ex->getMessage());
             $result["message"]  = "Dokumen telah didownload sebelumnya";
         }


         return $result;
     }

     public function downlodSignDocument($id_dokumen, $path)
     {
         $endpoint = env('API_BSRE_BASE_URI')."/sign/download/{$id_dokumen}";
    //     $credentials = base64_encode('ekgb_bkpp:e-KGB_@23');
  //08072026
        $credentials = base64_encode('ekgbbkpsdm:S1mp39@KGB');      
   $headers = [
              'Authorization' => "Basic {$credentials}",
           ];

         $client = new \GuzzleHttp\Client(['verify' => false]);
         $result = [];
         try {
             $response = $client->request('GET', "{$endpoint}", [
                'sink' => $path,
                'headers' => $headers,
                [
                    'debug' => true
                ]
           ]);


             $result["code"] = "200";
             $result["message"] = "success";
         } catch (\GuzzleHttp\Exception\ClientException $ex) {
             $response = $ex->getResponse();
             $result["code"] = $ex->getCode();
             $body = $response->getBody();

             \Log::error($ex->getMessage());
             $result["message"]  = "Dokumen telah didownload sebelumnya";
         }


         return $result;
     }

    public function addLog($transaction_id, $form_data, $endpoint = "", $status_code = "", $message = "")
    {
        $log = new LogBSRE();

        $log->transaction_id = $transaction_id;
        $log->nik = @$form_data[array_search('nik',array_column($form_data, 'name'))]['contents'];
        $log->user_id = Auth::user()->id;
        $log->url = $endpoint;
        $log->status_code = $status_code;
        $log->message = $message;
        $log->created_at = date('Y-m-d H:i:s');

        $log->save();
    }
 }
