<?php
namespace App\Repositories;

/**
 *
 */
class KpoRepository extends BaseRepository
{
    protected $unwrap=['data'];

    protected $path = '/api/kpo/sk';

    public function __construct()
    {
        $this->baseUrl = config('bkn.base_url_resource');
        $this->client = new \GuzzleHttp\Client(['verify' => false]);
    }

    public function fetchKpo()
    {
        $endpoint = $this->endpoint ?: $this->baseUrl.$this->path;
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
            \Log::error($e->getMessage());
            $result["message"]  = $e->getMessage();
        }
       
        return  $this->dataMapper($result);
    }

    public function fetchHistory($tglAwal, $tglAkhir)
    {
        $endpoint = $this->endpoint ?: "$this->baseUrl$this->path/hist/$tglAwal/$tglAkhir";
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
            \Log::error($e->getMessage());
            $result["message"]  = $e->getMessage();
        }
        
        return  $this->dataMapper($result);
    }
}
