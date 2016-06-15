<?php
//Process Callback after transaction


$dataPOST = trim(file_get_contents('php://input'));

//Parse the xml data

$xml = simplexml_load_string($checkoutResponse);
		$ns = $xml->getNamespaces(true);
		$soap = $xml->children($ns['SOAP-ENV']);
		$sbody = $soap->Body;
		$mpesa_response = $sbody->children($ns['ns1']);
		$rstatus = $mpesa_response->processCheckOutResponse;
		$status = $rstatus->children();		
		$s_msisdn = $status->MSISDN;
		$s_date = $status->{'M-PESA_TRX_DATE'};
		$s_transactionid = $status->{'M-PESA_TRX_ID'};
		$s_status = $status->TRX_STATUS;
		$s_returncode = $status->RETURN_CODE;
		$s_description = $status->DESCRIPTION;
		$s_merchant_transaction_id = $status->MERCHANT_TRANSACTION_ID;
		$s_encparams = $status->ENC_PARAMS;
		$s_txID = $status->TRX_ID;

	//Save the returned data into the database or use it to finish certain operation.
	
	if($s_status=="Success"){
		//Perfomr X operation

	}else{
		//Perform X operation
	}



?>