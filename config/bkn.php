<?php
return [
  'base_url_auth' => env('API_BKN_BASE_URI_AUTH','https://wstraining.bkn.go.id/oauth/token'),	
  'base_url_resource' => env('API_BKN_BASE_URI', 'https://wstraining.bkn.go.id/bkn-resources-server'),
  'base_url_duplex_resource' => env('API_BKN_BASE_URI_DUPLEX', 'https://wsrv-duplex-training.bkn.go.id'),
  'client_id' => env('CLIENT_ID', ''),
  'grant_type' => env('GRANT_TYPE', 'client_credentials')
];
?>
