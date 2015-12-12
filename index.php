<?php
require_once('config/Constant.php');
require_once('lib/MpesaAPI.php');


$Password=Constant::generateHash();
$mpesaclient=new MpesaAPI;
$mpesaclient->processCheckOutRequest($Password,MERCHANT_ID,"1232434","123454","60","254713038301",URL);

// exit;
// $url = "https://www.safaricom.co.ke/mpesa_online/lnmo_checkout_server.php";
// $MERCHANT_ID='917583';
// $passkey='4ea7c2c19eff694c94dec7e5f273c1c978d154df';
// $TIMESTAMP=new DateTime();
// $datetime=$TIMESTAMP->format('YmdHis');
// //$date->format('Y-m-d H:i:s')
// $PASSWORD=base64_encode(hash("sha256", $MERCHANT_ID.$passkey.$datetime));

// /*echo strtoupper($PASSWORD) ;
// exit;*/
// $post_string='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tns="tns:ns">
// <soapenv:Header>
//   <tns:CheckOutHeader>
// 	<MERCHANT_ID>917583</MERCHANT_ID>
// 	<PASSWORD>'.$PASSWORD.'</PASSWORD>
// 	<TIMESTAMP>'.$datetime.'</TIMESTAMP>
//   </tns:CheckOutHeader>
// </soapenv:Header>
// <soapenv:Body>
//   <tns:processCheckOutRequest>
// 	<MERCHANT_TRANSACTION_ID></MERCHANT_TRANSACTION_ID>
// 	<REFERENCE_ID>1112254500</REFERENCE_ID>
// 	<AMOUNT>54</AMOUNT>
// 	<MSISDN>254713038301</MSISDN>
// 	<CALL_BACK_URL>http://lipacard.co.ke</CALL_BACK_URL>
// 	<CALL_BACK_METHOD>xml</CALL_BACK_METHOD>
// 	<TIMESTAMP>'.$datetime.'</TIMESTAMP>
//   </tns:processCheckOutRequest>
// </soapenv:Body>
// </soapenv:Envelope>';

// $headers = array(  
// "Content-type: text/xml",
// "Content-length: ".strlen($post_string),
// "Content-transfer-encoding: text",
// "SOAPAction: \"processCheckOutRequest\"",
// );

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL,$url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
// curl_setopt($ch, CURLOPT_TIMEOUT, 10);
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
// curl_setopt($ch, CURLOPT_POST,TRUE); 
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POSTFIELDS,  $post_string); 
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
// // curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/safcom");
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// $data = curl_exec($ch);

// print "<pre>\n";
// echo "\n";
// print "Request:\n\n".htmlspecialchars($post_string);
// print "</pre>";

// if($data === FALSE)
// {
// 	$err = 'Curl error: ' . curl_error($ch);
// 	curl_close($ch);
// 	echo "Error \n".$err;
// }
// else
// {
// 	curl_close($ch);
// 	$body = $data;
// 	echo $body;
// 	//$myFile = '/home/vitozy/sites/site/client_log.txt';
// 	//file_put_contents($myFile, $body);
// 	/*$xml = simplexml_load_string($body);
// 	$ns = $xml->getNamespaces(true);
// 	$soap = $xml->children($ns['SOAP-ENV']);
// 	$sbody = $soap->Body;
// 	$quotes = $sbody->children($ns['tns']);
// 	$rstatus = $quotes->getQuoteResponse;
// 	$status = $rstatus->children();
// 	$s_request = $status->Request;
// 	$s_result = $status->Result;
// 	$ns_result = $rstatus->children($ns['tns']);
// 	$nsr_result = $ns_result[0];*/

// 	/*
// 	foreach ($getproductlistresponse->children() as $item)
// 	{
// 	  //This example just accesses the iid node but the others are all available.
// 	  echo (string) $item->iid . '<br />';
// 	}
// 	*/
// 	//Response
// /*	print "<pre>\n";
// 	echo "\n";
// 	print "Response XML:\n\n".htmlspecialchars($body);
// 	echo "\n\nResponse Value:\n".$body;
// 	echo "\n\nResult Value:\n".$s_result;
// 	echo "\n\nRequest Value:\n".$s_request;
// 	echo "\n\nResult Value NS:\n".$nsr_result;
// 	print "</pre>";*/
// }

//Expected respone
/*
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
xmlns:ns1="urn:xmethods-delayed-quotes" xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" 
SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
	<SOAP-ENV:Body>
		<ns1:getQuoteResponse>
			<Result xsi:type="xsd:float">98.42</Result>
		</ns1:getQuoteResponse></SOAP-ENV:Body>
</SOAP-ENV:Envelope>
*/

?>