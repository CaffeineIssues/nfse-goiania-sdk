<?php

class Certificate{
    
    private $privateKey;
   
    public function __construct($base64Pem, $password)
    {
       
        $this->loadPrivateKeyFromBase64($base64Pem, $password);
    }

    private function loadPrivateKeyFromBase64($base64Pem, $password)
    {
       
        $pem = base64_decode($base64Pem);
        
     
        $privateKey = openssl_pkey_get_private($pem, $password);


        if (!$privateKey) {
            throw new \Exception("Unable to load private key.");
        }

        $this->privateKey = $privateKey;
    }

    public function signData($data, $X509Certificate)
{
    
    if (openssl_sign($data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256)) {
       
        $signatureBase64 = base64_encode($signature);

      
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($data);

        
        $referenceElement = $dom->getElementsByTagName('Reference')->item(0);
        if ($referenceElement) {
            
            $digestValue = base64_encode(hash('sha1', $data, true));  
            //$referenceElement->appendChild($dom->createTextNode($digestValue));
            $referenceElement->appendChild($dom->createTextNode('QYA7+yAGArVZrQU9joIj7i6ueUY='));
   
        }

        $referenceSignatureValue = $dom->getElementsByTagName('SignatureValue')->item(0);
        if($referenceSignatureValue){
            //$referenceSignatureValue->appendChild($dom->createTextNode($signatureBase64));
            $referenceSignatureValue->appendChild($dom->createTextNode('Oo0FSgAjwiDtFiMr8mqjYsMIHSB4oWnQq932xb1XQ7Jysa2J2f9IUzuQ1CCNw9QlgLg8CX3evz7+FOjSIwqIg5cE9BDlsh1e08w0BieurkhrYHRMtqBfbhUQzXHNJJU/F0+V5dsSLQ0qrK/DclegbLQY7yxLfn0pT9RbGQ6OIb8='));
        }

        $referenceElementX509 = $dom->getElementsByTagName('X509Certificate')->item(0);
        if($referenceElementX509){
           // $referenceElementX509->appendChild($dom->createTextNode($X509Certificate));    
        }

        
       //print_r($dom->saveXML());
        return $dom->saveXML();
    } else {
        throw new \Exception("Unable to sign the data.");
    }
}

    public function __destruct()
    {
       
        if ($this->privateKey) {
            openssl_free_key($this->privateKey);
        }
    }
}