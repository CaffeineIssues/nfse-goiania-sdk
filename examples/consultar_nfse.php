<?php
require('../src/NfseClient.php');


$config = [
    'certificado' => 'path/to/certificado.pfx',
    'homologacao' => true
];

$client = new NfseClient($config);
