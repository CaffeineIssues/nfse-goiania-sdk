<?php
require('services/CertificateService.php');
require('services/NfseService.php');

class NfseClient
{
    private $certificado;
    private $homologacao;

    public function __construct(array $config)
    {
        $this->certificado = isset($config['certificado']) ? $config['certificado'] : '';
        $this->homologacao = isset($config['homologacao']) ? (bool) $config['homologacao'] : true;
        
        $this->inicializar();
        

      
    }

    private function inicializar()
    {
        if (!$this->certificado) {
            throw new \Exception("Certificado não encontrado: {$this->certificado}");
        }
       // $signatureService = new SignatureService($base64Pem, $password);
       $this->generateNfse = new NfseService();
    
       $this->generateNfse->gerar();
    

        
    }

    public function getAmbiente()
    {
        return $this->homologacao ? 'hom' : 'prod';
    }

   
}