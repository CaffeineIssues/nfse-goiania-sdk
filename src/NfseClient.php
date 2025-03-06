<?php
require('services/CertificateService.php');
require('services/NfseService.php');




class NfseClient
{
    private $certificado;
    private $homologacao;
    private $senha;

    public function __construct(array $config)
    {
        $this->certificado = isset($config['certificado']) ? $config['certificado'] : '';
        $this->senha = isset($config['senha']) ? $config['senha'] : '';
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
        
    }

    public function getAmbiente()
    {
        return $this->homologacao ? 'hom' : 'prod';
    }

    public function gerarNfse(
        $dadosNfse
    )
    {
        $nfse = new Nfse($dadosNfse);
        return $this->generateNfse->gerar(
            $nfse,
            $this->certificado,
            $this->senha
        );
    }
   
}