<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 18-3-7
 * Time: 下午2:37
 */

namespace App\Service;


class CryptAes
{
    private $key;
    private $iv;

    public function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv = $iv;
    }
    /**
     * Encrypt and decrypt
     *
     * @author Nazmul Ahsan <n.mukto@gmail.com>
     * @link http://nazmulahsan.me/simple-two-way-function-encrypt-decrypt-string/
     *
     * @param string $string string to be encrypted/decrypted
     * @param string $action what to do with this? e for encrypt, d for decrypt
     */
    function my_simple_crypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = 'my_simple_secret_key';
        $secret_iv = 'my_simple_secret_iv';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;
    }



    public function encrypt($plainText){
        $key = $this->key;
        $iv = $this->iv;

        $encrypted = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $key );
        $iv = substr( hash( 'sha256', $iv ), 0, 16 );

        $encrypted = base64_encode( openssl_encrypt( $plainText, $encrypt_method, $key, 0, $iv ) );
        return $encrypted;
    }
    public function decrypt($ciphertext){

        $key = $this->key;
        $iv = $this->iv;

        $decrypted = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $key );
        $iv = substr( hash( 'sha256', $iv ), 0, 16 );

        $decrypted = openssl_decrypt( base64_decode( $ciphertext ), $encrypt_method, $key, 0, $iv );
        return $decrypted;


    }
}