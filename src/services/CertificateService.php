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

    public function signData($xml, $certificadoBase64)
    {
        if (!$this->privateKey) {
            throw new \Exception("Private key is not set or invalid.");
        }

   
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadXML($xml);
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = false;

  
        $rpsNode = $doc->getElementsByTagName("Rps")->item(0);
        if (!$rpsNode) {
            throw new \Exception("Rps element not found.");
        }

        $canonicalData = $rpsNode->C14N(true, false);
        $digestValue = base64_encode(hash('sha1', $canonicalData, true));

      
        $signedInfoXml = '
        <SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#">
            <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></CanonicalizationMethod>
            <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"></SignatureMethod>
            <Reference URI="">
                <Transforms>
                    <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform>
                    <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"></Transform>
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"></DigestMethod>
                <DigestValue>' . $digestValue . '</DigestValue>
            </Reference>
        </SignedInfo>';
    

        if (!openssl_sign($signedInfoXml, $signature, $this->privateKey, OPENSSL_ALGO_SHA1)) {
            throw new \Exception("Failed to sign the XML.");
        }

        $signatureValue = base64_encode($signature);

       
        $signatureXml = '
        <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
            ' . $signedInfoXml . '
            <SignatureValue>' . $signatureValue . '</SignatureValue>
            <KeyInfo>
                <X509Data>
                    <X509Certificate>' . $certificadoBase64 . '</X509Certificate>
                </X509Data>
            </KeyInfo>
        </Signature>';
       
        $signatureDom = new DOMDocument();
        $signatureDom->loadXML($signatureXml, LIBXML_NOXMLDECL); 
        
        
        foreach ($signatureDom->getElementsByTagName('*') as $node) {
            if ($node->nodeType === XML_ELEMENT_NODE && $node->childNodes->length === 0) {
               
                $node->appendChild($signatureDom->createTextNode(''));
            }
        }
        
     
        $importedNode = $doc->importNode($signatureDom->documentElement, true);
        $rpsNode->appendChild($importedNode);
        //print_r($doc->saveXML());
        return $doc->saveXML();
    }

    public function __destruct()
    {
       
        if ($this->privateKey) {
            openssl_free_key($this->privateKey);
        }
    }
}

?>