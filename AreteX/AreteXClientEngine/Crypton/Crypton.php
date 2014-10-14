<?php
include 'Crypt/RSA.php';
include('Crypt/Rijndael.php');

/**
 * Crypton
 * 
 * @package Crypton  
 * @author David Brumbaugh
 * @copyright 2014 - 3B Alliance, LLC
 * @version 1.0
 * @access public
 * @license LGPL 2.1 or Later: http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 * 
 * Wrapper for phpseclib 
 * 
 * 1. Encrypt arbitrarily large messages with asyemmtric keys.
 * 2. Enccapsulate Sign/Verify with base64 encoding
 * 3. Ecrypted storage of key pairs.
 * 
 * Usage: 
 * 
 * $crypt = new Crypton();
 * $encrypted = $crypt->encrypt_message($message,$private_key);
 * $deccrypted = $crypt->decrypt_message($encrypted,$public_key);
 * 
 * It also works if public and private keys are swapped:
 * 
 * $encrypted = $crypt->encrypt_message($message,$public_key);
 * $deccrypted = $crypt->decrypt_message($encrypted,$private_key);
 * 
 * As this is a wrapper for phpseclib, please see RSA.php for key generation and usage.
 * @link       http://phpseclib.sourceforge.net 
 * 
 * Yes, I had just finished watching some reruns of Smallville when I named this class.
 * 
 * 
 * LICENSE: Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 */
class Crypton {
    
    public function __construct() {
        
        $this->rsa = new Crypt_RSA();
        $this->rij = new Crypt_Rijndael();
        
    }
    
    protected $rsa;
    protected $rij;

    
    /**
     * Crypton::encrypt_message()
     * 
     * Encrypt a message with an asymetrical key.
     * 
     * @param mixed $message - Message to Enrypt
     * @param mixed $asym_key - Asyemmtric Key Public or Private Key (Decrypt with the opposite)
     * @return ecrypted message
     */
    public function encrypt_message($message,$asym_key)
    {
         
        $sem_key = $this->generate_sym_key();                    
        $this->rij->setKey($sem_key);
        $message = $this->rij->encrypt($message);
        $message = base64_encode($message); 
                    
        $this->rsa->loadKey($asym_key);
        $sem_key = $this->rsa->encrypt($sem_key);
        $sem_key = base64_encode($sem_key);
        $len = strlen($sem_key);
        
        $len = dechex($len);
        $len = str_pad($len,3,'0',STR_PAD_LEFT);
        $message = $len.$sem_key.$message;
                                                        
 
         return $message;
    }
    
    /**
     * Crypton::decrypt_message()
     * 
     * Decrypt a message with an asymetrical key.
     * 
     * @param mixed $message - Encrypted message 
     * @param mixed $asym_key - Asyemmtric Key Public or Private Key (Encrypted with the opposite)
     * @return decrypted message
     */
    public function decrypt_message($message,$asym_key)
    {
         
          
        $len = substr($message,0,3); 
        $len = hexdec($len);
                
        $message = substr($message,3);
        $sem_key = substr($message,0,$len);
        $message = substr($message,$len);
        $message = base64_decode($message);
        
        $this->rsa->loadKey($asym_key);
        $sem_key = base64_decode($sem_key);
        $sem_key = $this->rsa->decrypt($sem_key);
       
        $this->rij->setKey($sem_key);
                       
        $message = $this->rij->decrypt($message);
                                                        
 
         return $message;
    }
    
    /**
     * Crypton::sign()
     * 
     * Sign message with a private key and base64 encode
     * 
     * @param mixed $message
     * @param mixed $private_key
     * @return base 64 encoded signature
     */
    public function sign($message,$private_key) {        
        if (! $this->rsa->loadKey($private_key))
        {
            return false;
        }          
        $signature  =  $this->rsa->sign($message);
        $signature =  base64_encode($signature);
        
        return $signature;
    }
    
    
    /**
     * Crypton::verify()
     * 
     * Verify a base 64 encoded signature with a public key
     * 
     * @param mixed $message
     * @param mixed $signature
     * @param mixed $public_key
     * @return
     */
    public function verify($message,$signature,$public_key) {        
        if (! $this->rsa->loadKey($public_key))
        {
            return false;
        } 
        $signature = base64_decode($signature);                 
        return $this->rsa->verify($message,$signature);
        
    }
    
    
    /**
     * Crypton::generate_sym_key()
     * 
     * Generates a random seymetic key.  The symmetric key will be used to encrypt the main 
     * body of the message.  It will then be encrypted asymmetrically and prepended to the message.
     * 
     * @return  Random symmetric key 
     */
    public function generate_sym_key()
    {        
        $len = rand(32,128);
        $sem_key = crypt_random_string($len);   
        
        return $sem_key;
    }
    
    /**
     * Crypton::store_keys()
     * 
     * Stores a keypair in an encrypted file, so a private key stays private.
     * 
     * @param mixed $keypair  - Keypair to store
     * @param mixed $keypair_name - name by which to refer to the keypair.  Note if the name already exists,
     *              it will be overwritten without warning with the new values.
     * @param mixed $password - password to protect the key pair storage. 
     * @param boolean $force - true if you want to force the password to be "correct" - if the passed password
     *                         does not match the old one, the file will be overwritten with the new password. 
     * @return void
     */
    public function store_keys($keypair,$keypair_name,$password,$force=false)
    {
        $key_file = dirname(__FILE__).'/keys/crypton.enc';
        $this->rij->setKey($password);
        if (file_exists($key_file) && ($enc = file_get_contents($key_file)))
        {            
            $message = $this->rij->decrypt($enc);
            if ((! $message) && (! $force)) // Wrong password - force will create a new file if the password is wrong.
                return null;
            
            $keys = unserialize($message);
        }
        else
        {
            $keys = array();
        }
        $keys[$keypair_name] = $keypair;
        $message = serialize($keys);
        $enc = $this->rij->encrypt($message);
        file_put_contents($key_file,$enc);
        
    }
    
    public function key_file_exists() {
        $key_file = dirname(__FILE__).'/keys/crypton.enc';
        return file_exists($key_file);
    }
    
    public function get_keys_for_backup() {
        $key_file = dirname(__FILE__).'/keys/crypton.enc';
        $enc = null;
        if (file_exists($key_file) && ($enc = file_get_contents($key_file))){
            $enc = base64_encode($enc);
            
        }
        return $enc;
    }
    
 
    public function restore_keys_from_backup($enc) {
        $key_file = dirname(__FILE__).'/keys/crypton.enc';
        $enc = base64_decode($enc);
        if ($enc) {
            file_put_contents($key_file,$enc);           
        }
        
    }
    
    /**
     * Crypton::get_keys()
     * 
     * Returns the named keypair from the encrypted file.
     * 
     * @param mixed $keypair_name
     * @param mixed $password
     * @return - Keypair array (publickey,privatekey)
     */
    public function get_keys($keypair_name,$password)
    {
        $keys = array();
        $key_file = dirname(__FILE__).'/keys/crypton.enc';
        if (! file_exists($key_file))
            return null;
        $this->rij->setKey($password);
        if (($enc = file_get_contents($key_file)))
        {            
            $message = $this->rij->decrypt($enc);
            if ($message)
                $keys = unserialize($message);
        }
        return $keys[$keypair_name];
    }
    
    /**
     * Crypton::change_password()
     * 
     * Change passwords on the encrypted key file. 
     * 
     * @param mixed $old_password
     * @param mixed $new_password
     * @return void
     */
    public function change_password($old_password,$new_password)
    {
        $key_file = dirname(__FILE__).'/keys/crypton.enc';
        $this->rij->setKey($old_password);
        if (($enc = file_get_contents($key_file)))
        {            
            $message = $this->rij->decrypt($enc);
            if ($message)
            {
                $this->rij->setKey($new_password);
                $enc = $this->rij->encrypt($message);
                file_put_contents($key_file,$enc);
            }
           
        }
    }
    
}


?>