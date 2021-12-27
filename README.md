
# How to Test REST API at Client 

<?php
to access get All Inventory use 
$url = 'http://localhost:8080/api/inventory/';
$method = 'GET'

to access get show specific Inventory use 
$url = 'http://localhost:8080/api/inventory/(:id)';
$method = 'GET';

to access CREATE specific Inventory use 
$url = 'http://localhost:8080/api/inventory/';
$method = 'POST';

to access UPDATE specific Inventory use 
$url = 'http://localhost:8080/api/inventory/(:id)';
$method = 'PUT';

to access DELETE specific Inventory use 
$url = 'http://localhost:8080/api/inventory/(:id)';
$method = 'DELETE';

$api_key = $2y$10$uQkDGqmPHuSF24.OiIWghuhbhx32M0zYc7P5xLQ2zCFpkYy9ujl0K;


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_POSTFIELDS      => $data,
  CURLOPT_CUSTOMREQUEST   => $method,
  CURLOPT_URL             => $url,
  CURLOPT_RETURNTRANSFER  => true,
  CURLOPT_HTTPHEADER      => array(
	  'Authorization:'. $api_key
  )
));
$result = curl_exec($curl);
print_r(json_decode($result, true));

?>
