<?php
/**
 * This code is Jamhuri special and it enables you to access buygoods functionality
 * from any system build on top of php.
 * @author Derrick Rono <derrickrono@gmail.com>
 */
require_once('config/Constant.php');
require_once('lib/MpesaAPI.php');



//Get the server address for callback
$host=gethostname();
$ip = gethostbyname($host);

$Password=Constant::generateHash();
$mpesaclient=new MpesaAPI;

/**
 * Make payment
 */
if($_GET['transactionType']=='checkout'){
	//Replace the data with relevant information
	$mpesaclient->processCheckOutRequest($Password,MERCHANT_ID,"XsdscRTysjssdkg","123454","10","254713038301",$ip);
}
else if ($_GET['transactionType']=='txStatus') {
	//Replace the data with relevant information
	$TXID=$_GET['txid'];
	$MERCHANT_TRANSACTION_ID=$_GET['mt_id'];
	$mpesaclient->statusRequest($Password,MERCHANT_ID,$TXID,$MERCHANT_TRANSACTION_ID);
}
else{

	echo json_encode("No operation selected")
}




?>
