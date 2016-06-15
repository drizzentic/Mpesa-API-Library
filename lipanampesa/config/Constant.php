<?php
/**
 * This code is Jamhuri special and it enables you to access buygoods functionality
 * from any system build on top of php.
 * @author Derrick Rono <derrickrono@gmail.com>
 */

/**
 * Constants for authentication
 */
define("MERCHANT_ID",''); //Put the unique merchant ID provided by the service provider.
define("PASSKEY", ''); //Put the passkey provided for SAG access
define("URL", "https://www.safaricom.co.ke/mpesa_online/lnmo_checkout_server.php?wsdl"); //Put the api endpint.
define('Cert_location','');
/**
 * Function to generate the password
 * 
 */
/**
* 
*/
class Constant 
{
	public function generateHash(){

	$TIMESTAMP=new DateTime();
	$datetime=$TIMESTAMP->format('YmdHis');
	$password=base64_encode(hash("sha256", MERCHANT_ID.PASSKEY.$datetime));

	return $password;
	}
}


?>
