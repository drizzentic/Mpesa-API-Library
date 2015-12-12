<?php

/**
* Class to allow access to mpesa end points
*/
class MpesaApi
{
	
	function __construct()
	{		
		
	}
	public function processCheckOutRequest($password,$MERCHANT_ID,$MERCHANT_TRANSACTION_ID,$REFERENCE_ID,$AMOUNT,$MSISDN,$CALL_BACK_URL){
		$TIMESTAMP=new DateTime();
		$datetime=$TIMESTAMP->format('YmdHis');
		/*
		Create A soap Message with parameters
		 */
		$post_string='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tns="tns:ns">
		<soapenv:Header>
		  <tns:CheckOutHeader>
			<MERCHANT_ID>'.$MERCHANT_ID.'</MERCHANT_ID>
			<PASSWORD>'.$password.'</PASSWORD>
			<TIMESTAMP>'.$datetime.'</TIMESTAMP>
		  </tns:CheckOutHeader>
		</soapenv:Header>
		<soapenv:Body>
		  <tns:processCheckOutRequest>
			<MERCHANT_TRANSACTION_ID>'.$MERCHANT_TRANSACTION_ID.'</MERCHANT_TRANSACTION_ID>
			<REFERENCE_ID>'.$REFERENCE_ID.'</REFERENCE_ID>
			<AMOUNT>'.$AMOUNT.'</AMOUNT>
			<MSISDN>'.$MSISDN.'</MSISDN>
			<!--Optional parameters-->
			<CALL_BACK_URL>'.$CALL_BACK_URL.'</CALL_BACK_URL>
			<CALL_BACK_METHOD>xml</CALL_BACK_METHOD>
			<TIMESTAMP>'.$datetime.'</TIMESTAMP>
		  </tns:processCheckOutRequest>
		</soapenv:Body>
		</soapenv:Envelope>';
		/*
		Headers
		 */
		$headers = array(  
		"Content-type: text/xml",
		"Content-length: ".strlen($post_string),
		"Content-transfer-encoding: text",
		//"SOAPAction: \"processCheckOutRequest\"",
		);
		$this->submitRequest($CALL_BACK_URL,$post_string,$headers);
	}

	public function submitRequest($url,$post_string,$headers){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST,TRUE); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $post_string); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		// curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/safcom");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$data = curl_exec($ch);
/*
		print "<pre>\n";
		echo "\n";
		print "Request:\n\n".htmlspecialchars($post_string);
		print "</pre>";*/

		if($data === FALSE)
		{
			$err = 'Curl error: ' . curl_error($ch);
			curl_close($ch);
			echo "Error \n".$err;
		}
		else
		{
			curl_close($ch);
			$body = $data;
			
		}
		return $body;
}
}
?>