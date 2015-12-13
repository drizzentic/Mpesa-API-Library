<?php
/**
 * This code is Jamhuri special and it enables you to access buygoods functionality
 * from any system build on top of php.
 * @author Derrick Rono <derrickrono@gmail.com>
 */

/**
 * Constants for authentication
 */
define("MERCHANT_ID",'917583'); //Put the unique merchant ID provided by the client.
define("PASSKEY", '4ea7c2c19eff694c94dec7e5f273c1c978d154df'); //Put the passkey provided for SAG access
define("URL", "https://www.safaricom.co.ke/mpesa_online/lnmo_checkout_server.php?wsdl"); //Put the api endpint.

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