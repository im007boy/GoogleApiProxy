<?php
// PHP Proxy
// Responds to both HTTP GET and POST requests
//
// Author: Abdul Qabiz
// March 31st, 2006
//
 
// Get the url of to be proxied
// Is it a POST or a GET?
$fp = fopen('php://input','r');
$payload = fgets($fp);
//echo $payload;
//{"Method":"GET","absoluteURI":"https://picasaweb.google.com/data/feed/api/","headers":{"GData-Version%2B":"2"},"message-body":"","access_token":"ya29.dsdf","access_token_type":"query"}
$param = json_decode($payload);
 
//Start the Curl session
$session = curl_init($url);
// echo $param->{'absoluteURI'};
// echo $param->{'message-body'};


//curl_setopt($session, CURLOPT_PROXY, 'http://localhost:8888');
curl_setopt($session, CURLOPT_URL, $param->{'absoluteURI'} );  
// If it's a POST, put the POST data in the body
if ($param->{'Method'} == "POST") {
	curl_setopt ($session, CURLOPT_POST, true);
	curl_setopt ($session, CURLOPT_POSTFIELDS, $param->{'message-body'});
}
 
// Don't return HTTP headers. Do return the contents of the call

//$headers[] = "Content-type: application/json; charset=UTF-8";
while (list($key, $val) = each($param->{'headers'})){
   $headers[] = "$key: $val";
}

// print_r( $headers );

curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //设置http头 
curl_setopt($session, CURLOPT_HEADER, 0);  
curl_setopt($session, CURLOPT_ENCODING, "gzip" );         //设置为客户端支持gzip压缩
 
curl_setopt($session, CURLOPT_FOLLOWLOCATION, true); 
//curl_setopt($session, CURLOPT_TIMEOUT, 4); 
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
 
// Make the call
$response = curl_exec($session);
// echo "====\n";
curl_close($session);
$http_origin = $_SERVER['HTTP_ORIGIN'];

if (filter_var($http_origin, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/\/\/.*?(127.0.0.1|im007boy\.com|neverbest\.com)$/")))){  
    header('Access-Control-Allow-Origin: *');
}
echo $response;
 
?>