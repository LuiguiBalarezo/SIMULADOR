<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cryptography {

	public function Encrypt($password) {

		// $password = 'gf45_gdf#4hg';

		// A higher "cost" is more secure but consumes more processing power
		$cost = 10;

		// Create a random salt
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

		// Prefix information about the hash so PHP knows how to verify it later.
		// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
		$salt = sprintf("$2a$%02d$", $cost) . $salt;

		// Value:
		// $2a$10$eImiTXuWVxfM37uY4JANjQ==

		// Hash the password with the salt
		$hash = crypt($password, $salt);

		// Value:
		// $2a$10$eImiTXuWVxfM37uY4JANjOL.oTxqp7WylW7FCzx2Lc7VLmdJIddZq

		return $hash;

	}

	public function validateHash($hash, $password) {

		if ( hash_equals($hash, crypt($password, $hash)) ) {
			return true;
		}

		return false;
	}

}