<?php
ini_set("soap.wsdl_cache_enabled", "0");
/**
 * This code is Jamhuri special and it enables you to access buygoods functionality
 * from any system build on top of php.
 * @author Derrick Rono <derrickrono@gmail.com>
 */

/**
* Class to allow access to lipa na mpesa online checkout
*/
class MpesaApi
{

	public function processCheckOutRequest($password,$MERCHANT_ID,$MERCHANT_TRANSACTION_ID,$REFERENCE_ID,$AMOUNT,$MSISDN,$CALL_BACK_URL){
		$TIMESTAMP=new DateTime();
		$datetime=$TIMESTAMP->format('YmdHis');
		/*
		Create A soap Message with parameters
		 */
		/*$params = array(
			//'CheckOutHeader'=>array(
				'MERCHANT_ID'=>$MERCHANT_ID,
            	'PASSWORD'=>$password,
            	'TIMESTAMP'=>$datetime,
			//	),
			//'processCheckOutRequest'=>array(
	            'MERCHANT_TRANSACTION_ID'=>$MERCHANT_TRANSACTION_ID,
	            'REFERENCE_ID'=>$REFERENCE_ID,
	            'AMOUNT'=>$AMOUNT,
	            'MSISDN'=>$MSISDN,
	            'ENC_PARAMS'=>"CrazyL",
	            'CALL_BACK_URL'=>$CALL_BACK_URL,
	            'CALL_BACK_METHOD'=>"post",	            
	            'TIMESTAMP'=>$datetime
			//	)
            
            );
		//print_r($params);*/
		/*$soap = new SOAPClient(URL,array("trace"  => 0, "exceptions" => 0,
			"stream_context" => stream_context_create(
			        array(
			            'ssl' => array(
			                'verify_peer'       => false,
			                'verify_peer_name'  => false,
            		)
       
        			)
    			),'location'=>'https://www.safaricom.co.ke/mpesa_online/lnmo_checkout_server.php'
			));
		echo $soap->processCheckOut($params);
		

		//print_r($soap->__call('processCheckOut',array($params));
		exit;*/
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
		/*
		To get the feedback from the process request system
		For debug purposes only
		 */
		$response=$this->submitRequest(URL,$post_string,$headers);
		echo $response;
		/*
		To get the feedback from the process transaction system
		For debug purposes only
		 */
		echo "Confirm transaction feedback: ".$this->confirmTransaction($response,$datetime,$password);

	}
	/*
	The Merchant makes a SOAP call to the SAG to confirm an online checkout transaction
	 */
	public function confirmTransaction($checkoutResponse,$datetime,$password){		
		$xml = simplexml_load_string($checkoutResponse);
		$ns = $xml->getNamespaces(true);
		$soap = $xml->children($ns['SOAP-ENV']);
		$sbody = $soap->Body;
		$mpesa_response = $sbody->children($ns['ns1']);
		$rstatus = $mpesa_response->processCheckOutResponse;
		$status = $rstatus->children();		
		$s_returncode = $status->RETURN_CODE;
		$s_description = $status->DESCRIPTION;
		$s_transactionid = $status->TRX_ID;
		$s_enryptionparams = $status->ENC_PARAMS;
		$s_customer_message = $status->CUST_MSG;
		if($s_returncode==42){

			echo json_encode("Authentication Failed",401);
		}
		$confirmTransactionResponse='
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tns="tns:ns">
		   <soapenv:Header>
		      <tns:CheckOutHeader>
		         <MERCHANT_ID>'.MERCHANT_ID.'</MERCHANT_ID>
			<PASSWORD>'.$password.'</PASSWORD>
			<TIMESTAMP>'.$datetime.'</TIMESTAMP>
		      </tns:CheckOutHeader>
		   </soapenv:Header>
		   <soapenv:Body>
		      <tns:transactionConfirmRequest>
		         <!--Optional:-->
		         <TRX_ID>'.$s_transactionid.'</TRX_ID>
		         <!--Optional:-->
		         <MERCHANT_TRANSACTION_ID>911-000</MERCHANT_TRANSACTION_ID>
		      </tns:transactionConfirmRequest>
		   </soapenv:Body>
		</soapenv:Envelope>';

		$headers = array(  
		"Content-type: text/xml",
		"Content-length: ".strlen($confirmTransactionResponse),
		"Content-transfer-encoding: text",
		//"SOAPAction: \"processCheckOutRequest\"",
		);

		return $this->submitRequest(URL,$confirmTransactionResponse,$headers);
		
	}

	function submitRequest($url,$post_string,$headers){
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
