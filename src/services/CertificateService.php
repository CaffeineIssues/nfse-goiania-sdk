<?php

class Certificate{
    
    private $privateKey;

    public function __construct($base64Pem, $password)
    {
        // Load the private key from the base64-encoded PEM string
        $this->loadPrivateKeyFromBase64($base64Pem, $password);
    }

    private function loadPrivateKeyFromBase64($base64Pem, $password)
    {
        // Decode the base64 PEM string
        $pem = base64_decode($base64Pem);
        
        // Extract the private key from the PEM
        $privateKey = openssl_pkey_get_private($pem, $password);

        if (!$privateKey) {
            throw new \Exception("Unable to load private key.");
        }

        $this->privateKey = $privateKey;
    }

    public function signData($data)
    {
        // Sign the data
        if (openssl_sign($data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256)) {
            // Return the signature as a base64-encoded string
            return base64_encode($signature);
        } else {
            throw new \Exception("Unable to sign the data.");
        }
    }

    public function __destruct()
    {
        // Clean up the private key when done
        if ($this->privateKey) {
            openssl_free_key($this->privateKey);
        }
    }
}