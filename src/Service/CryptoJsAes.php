<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 17-10-8
 * Time: 下午12:07
 */

namespace App\Service;


class CryptoJsAes
{
    protected $salt;
    protected $iv;
    protected $passPhrase;

    public function __construct($passPhrase, $salt, $iv)
    {

        $this->passPhrase = $passPhrase;
        $this->salt = $salt;
        $this->iv = $iv;
    }

    public function encrypt($plainText){
        $salt = $this->salt;
        $iv  = $this->iv;
        $passphrase = $this->passPhrase;
        $iterations = 999;

        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);
        $encrypted = openssl_encrypt($plainText, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);
        return $encrypted;
    }
    public function decrypt($ciphertext){

        $salt = $this->salt;
        $iv  = $this->iv;
        $passphrase = $this->passPhrase;
        $iterations = 999; //same as js encrypting

        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

        $decrypted= openssl_decrypt($ciphertext , 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

        return $decrypted;

    }



    public function CryptoJSAesEncrypt($passphrase, $plain_text){

        $salt = openssl_random_pseudo_bytes(256);
        $iv = openssl_random_pseudo_bytes(16);
        //on PHP7 can use random_bytes() istead openssl_random_pseudo_bytes()
        //or PHP5x see : https://github.com/paragonie/random_compat

        $iterations = 999;
        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

        $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

        $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));
        return json_encode($data);
    }

    public function CryptoJSAesDecrypt($passphrase, $jsonString){

        $jsondata = json_decode($jsonString, true);
        try {
            $salt = hex2bin($jsondata["salt"]);
            $iv  = hex2bin($jsondata["iv"]);
        } catch(Exception $e) { return null; }

        $ciphertext = base64_decode($jsondata["ciphertext"]);
        $iterations = 999; //same as js encrypting

        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

        $decrypted= openssl_decrypt($ciphertext , 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

        return $decrypted;

    }

}