<?php

class Client
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
        if (!file_exists($this->certificado)) {
            throw new \Exception("Certificado não encontrado: {$this->certificado}");
        }

        // Aqui você pode carregar o certificado, criar uma conexão segura, etc.
    }

    public function getAmbiente()
    {
        return $this->homologacao ? 'Homologação' : 'Produção';
    }
}