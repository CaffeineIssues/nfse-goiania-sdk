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
$date = new DateTime();

// Formata a data e hora para o formato desejado
$formattedDate = $date->format('Y-m-d\TH:i:s');

$dadosNfse = [
    'numero' => 1,
    'serie' => $ambiente ? 'TESTE' : '1',
    'tipo' => 1,
    'dataEmissao' => $formattedDate,
    'status' => 1,
    'valorServicos' => '45.00', //precisa ser decimal
    'valorPis' => '0.00', //precisa ser decimal
    'valorCofins' => '0.00', //precisa ser decimal
    'valorInss' => '0.00', //precisa ser decimal
    'valorCsll' => '0.00', //precisa ser decimal
    'descontoIncondicionado' => 0.00, //precisa ser decimal
    'codigoTributacaoMunicipio' => 620310000,
    'discriminacao' => 'TESTE DE WEBSERVICE SABETUDO',
    'codigoMunicipio' => '5208707', //precisa ser valido e ter 7 digitos
    'cpfCnpjPrestador' => '09370375000154', //precisa ter 14  digitos se n da erro de xml
    'inscricaoMunicipalPrestador' => 6912966, //precisa ser valido  se n da erro de xml
    'cpfCnpjTomador' => '78518695320', //deixar cpf vazio se for preencher cnpj
    'pessoa_juridica' => false, //deixar cnpj vazio se for preencher cnf
    'inscricaoMunicipalTomador' => '6912966',
    'razaoSocialTomador' => 'JOSE NETO SOARES',
    'enderecoTomador' => 'RUA 3',
    'numeroTomador' => 1003,
    'complementoTomador' => 1003,
    'bairroTomador' => 'CENTRO',
    'codigoMunicipioTomador' => '5208707', //precisa ser valido e ter 7 digitos
    'ufTomador' => 'GO',
];


$gerarNfse = $client->gerarNfse(
   $dadosNfse
);


print_r($gerarNfse);
?>