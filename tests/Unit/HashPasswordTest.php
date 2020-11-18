<?php

namespace Tests\Unit;

use \Tests\TestCase;
use App\Security\Password;
use App\Security\Hasher;

class HashPasswordTest extends TestCase
{
    /** @test */
    public function creates_hash_of_any_string()
    {
    	
    	$this->withoutExceptionHandling();
    	
    	$passString = 'Gh45Yhtegdsdfrer(:34';
    	
    	$password = new Password();
    	
    	$hasher = new Hasher($password);
    	
    	
    	//$password->has('binaryRaw');
    	
    	//$hasher->setUpCrypt('PBKDF2');    	
    	
    	//$hasher->generateHash($user, 'qwerty')->willReturn('hashed_pass');
    	

    }
}
