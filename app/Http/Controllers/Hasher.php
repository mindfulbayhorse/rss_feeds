<?php

namespace App\Http\Controllers;

class Hasher
{
	const PASS_LENGTH = 256;
	
	//function __construct(Password $password){
		function __construct(){
		
		//$this->password = $password;
		
	}
	
	function encrypt_PBKDF2($salt){
		
		sodium_crypto_pwhash_scryptsalsa208sha256(256);
		
	}
}
