# NFSe Goiânia SDK

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-blue)
![License](https://img.shields.io/badge/license-MIT-green)

Uma biblioteca PHP para integrar sistemas com a API de emissão de Nota Fiscal de Serviço Eletrônica (NFSe) da Prefeitura de Goiânia.

## Recursos

- Consulta de lotes e notas fiscais
- Emissão de NFSe
- Cancelamento de NFSe
- Suporte a autenticação via certificados digitais

## Requisitos

- PHP 7.4 ou superior
- Composer
- Extensão `openssl` ativada

## Instalação

Instale via Composer:
```sh
composer require meuvendor/nfse-goiania-sdk
```

## Configuração

Antes de utilizar a biblioteca, configure suas credenciais:
```php
use MeuVendor\NFSeGoiania\Client;

$client = new Client([
    'certificado' => '/caminho/para/seu_certificado.pfx',
    'senha' => 'sua_senha',
    'homologacao' => true, // true para ambiente de testes, false para produção
]);
```

## Uso

### Emitindo uma NFSe
```php
$nfseData = [
    'prestador' => [
        'cnpj' => '12345678000190',
        'inscricao_municipal' => '123456',
    ],
    'tomador' => [
        'cnpj' => '98765432000100',
        'razao_social' => 'Empresa Teste',
    ],
    'servico' => [
        'descricao' => 'Desenvolvimento de Software',
        'valor' => 1500.00,
    ],
];

$response = $client->emitirNFSe($nfseData);
print_r($response);
```

### Consultando uma NFSe
```php
$response = $client->consultarNFSe('12345');
print_r($response);
```

### Cancelando uma NFSe
```php
$response = $client->cancelarNFSe('12345', 'Motivo do cancelamento');
print_r($response);
```

## Licença

Este projeto está licenciado sob a MIT License - veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## Contribuição

Sinta-se à vontade para contribuir! Abra uma issue ou envie um pull request no [GitHub](https://github.com/seuusuario/nfse-goiania-sdk).

