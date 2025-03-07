<?php
require('../src/NfseClient.php');


$base64Pem = base64_encode(file_get_contents("certificado.pem"));


$config = [
    'certificado' => $base64Pem,
    'senha' => 'associacao',
    'homologacao' => true
];

$client = new NfseClient($config);

$ambiente = $client->getAmbiente();

$dadosNfse = [
    'numero' => 1,
    'serie' => $ambiente ? 'TESTE' : '1',
    'tipo' => 1,
    'dataEmissao' => '2011-08-12T00:00:00',
    'status' => 1,
    'valorServicos' => 6000.00,
    'valorPis' => 40.50,
    'valorCofins' => 40.50,
    'valorInss' => 10.50,
    'valorCsll' => 10.50,
    'descontoIncondicionado' => 500.00,
    'codigoTributacaoMunicipio' => 631190000,
    'discriminacao' => 'TESTE DE WEBSERVICE SABETUDO',
    'codigoMunicipio' => 2530000,
    'cpfCnpjPrestador' => 24329550130,
    'inscricaoMunicipalPrestador' => 1442678,
    'cpfCnpjTomador' => 28222148168,
    'inscricaoMunicipalTomador' => 1708,
    'razaoSocialTomador' => 'LUIZ AUGUSTO MARINHO NOLETO',
    'enderecoTomador' => 'RUA 3',
    'numeroTomador' => 1003,
    'complementoTomador' => 1003,
    'bairroTomador' => 'CENTRO',
    'codigoMunicipioTomador' => 5208707,
    'ufTomador' => 'GO',
];



$gerarNfse = $client->gerarNfse(
   $dadosNfse
);


print_r($gerarNfse);
?>