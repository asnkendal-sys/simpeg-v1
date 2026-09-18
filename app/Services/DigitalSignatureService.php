<?php
  namespace App\Services;

use App\Repositories\BsreApiRepository as BsreRepository;
use App\Modules\digitalsignature\signeddocument\Models\SigneddocumentModel;

class DigitalSignatureService
{
     protected $repoBsre;
     public function __construct(BsreRepository $repoBsre)
     {
         $this->repoBsre = $repoBsre;
     }

     public function handle($data)
     {
         $sign = $this->repoBsre->signDocument($data);
         // dd($sign);
         $downlodDocument =  $this->repoBsre->downlodDocument($sign["data"]["id_dokumen"]);
         $storeSignedToDb=SigneddocumentModel::create([
           "name"=>"file-{$sign["data"]["id_dokumen"]}-sign.pdf",
           "id_document" => $sign["data"]["id_dokumen"],
           "user_id" => \Session::get("user_id"),
           "role_id" => \Session::get("role_id"),
           "created_at" =>now(),
           "updated_at" =>now()
         ]);
         if ($storeSignedToDb) {
             return $downlodDocument;
         } else {
             return ["code"=>404, "Message"=>"Failed Store to Db"];
         }
     }
 }
