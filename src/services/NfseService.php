<?php


class Nfse {
    public int $numero;
    public string $serie;
    public int $tipo;
    public string $dataEmissao;
    public int $status;
    public float $valorServicos;
    public float $valorPis;
    public float $valorCofins;
    public float $valorInss;
    public float $valorCsll;
    public float $descontoIncondicionado;
    public int $codigoTributacaoMunicipio;
    public string $discriminacao;
    public int $codigoMunicipio;
    public int $cpfCnpjPrestador;
    public int $inscricaoMunicipalPrestador;
    public int $cpfCnpjTomador;
    public int $inscricaoMunicipalTomador;
    public string $razaoSocialTomador;
    public string $enderecoTomador;
    public int $numeroTomador;
    public int $complementoTomador;
    public string $bairroTomador;
    public int $codigoMunicipioTomador;
    public string $ufTomador;

    public function __construct(array $data) {
        $this->numero = $data['numero'];
        $this->serie = $data['serie'];
        $this->tipo = $data['tipo'];
        $this->dataEmissao = $data['dataEmissao'];
        $this->status = $data['status'];
        $this->valorServicos = $data['valorServicos'];
        $this->valorPis = $data['valorPis'];
        $this->valorCofins = $data['valorCofins'];
        $this->valorInss = $data['valorInss'];
        $this->valorCsll = $data['valorCsll'];
        $this->descontoIncondicionado = $data['descontoIncondicionado'];
        $this->codigoTributacaoMunicipio = $data['codigoTributacaoMunicipio'];
        $this->discriminacao = $data['discriminacao'];
        $this->codigoMunicipio = $data['codigoMunicipio'];
        $this->cpfCnpjPrestador = $data['cpfCnpjPrestador'];
        $this->inscricaoMunicipalPrestador = $data['inscricaoMunicipalPrestador'];
        $this->cpfCnpjTomador = $data['cpfCnpjTomador'];
        $this->inscricaoMunicipalTomador = $data['inscricaoMunicipalTomador'];
        $this->razaoSocialTomador = $data['razaoSocialTomador'];
        $this->enderecoTomador = $data['enderecoTomador'];
        $this->numeroTomador = $data['numeroTomador'];
        $this->complementoTomador = $data['complementoTomador'];
        $this->bairroTomador = $data['bairroTomador'];
        $this->codigoMunicipioTomador = $data['codigoMunicipioTomador'];
        $this->ufTomador = $data['ufTomador'];
    }
}

class NfseService{

    private function NfseWSReq($wsdlUrl, $soapAction, $soapRequest){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $wsdlUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soapRequest);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: text/xml; charset=utf-8",
            "SOAPAction: \"$soapAction\"",
            "Content-Length: " . strlen($soapRequest),
        ]);

   
        $response = curl_exec($ch);
        $json_response;
   

        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            
            $response_headers = curl_getinfo($ch);
            if($response_headers['http_code'] == 400){
                $json_response =  json_encode(["error" => "Erro ao gerar NFSe", "message" => "requisição invalida(possivel erro no xml enviado)", "status" => 400]);
               
                return $json_response;
            }
            if($response_headers['http_code'] == 500){
                $json_response =  json_encode(["error" => "Erro ao gerar NFSe", "message" => "Erro interno no servidor", "status" => 500]);
              
                return $json_response;
            }
       
            $doc = new DOMDocument();
            $doc->loadXML($response);
            // Get the XML root node
            $root = $doc->documentElement;
            $responseContent = $root->nodeValue;
            $json_response = [];
            foreach ($root->childNodes as $node) {
                $json_response[$node->nodeName] = $node->nodeValue;
            }
            $json_response = $json_response['soap:Body'];
           
            $xmlObject = simplexml_load_string($json_response);
            $generateNfseResponse = json_decode(json_encode($xmlObject));
            
            return($generateNfseResponse);        
        }

        curl_close($ch);
    }
    public function gerar(
       Nfse $nfse
    ){
       print_r($nfse);
        // NFSe Web Service URL
        $wsdlUrl = "https://nfse.goiania.go.gov.br/ws/nfse.asmx";

        // SOAP Action
        $soapAction = "http://nfse.goiania.go.gov.br/ws/GerarNfse";

       

        // XML Data (Dynamic)
        $xmlData = 
        <<<XML
        <GerarNfseEnvio xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd">
                                <Rps>
                                    <InfDeclaracaoPrestacaoServico xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd">
                                        <Rps Id="rps1F">
                                            <IdentificacaoRps>
                                                <Numero>1</Numero>
                                                <Serie>F</Serie>
                                                <Tipo>1</Tipo>
                                            </IdentificacaoRps>
                                            <DataEmissao>2011-08-12T00:00:00</DataEmissao>
                                            <Status>1</Status>
                                        </Rps>
                                        <Servico>
                                            <Valores>
                                                <ValorServicos>6000.00</ValorServicos>
                                                <ValorPis>40.50</ValorPis>
                                                <ValorCofins>40.50</ValorCofins>
                                                <ValorInss>10.50</ValorInss>
                                                <ValorCsll>10.50</ValorCsll>
                                                <DescontoIncondicionado>500.00</DescontoIncondicionado>
                                            </Valores>
                                            <CodigoTributacaoMunicipio>631190000</CodigoTributacaoMunicipio>
                                            <Discriminacao>TESTE DE WEBSERVICE SABETUDO</Discriminacao>
                                            <CodigoMunicipio>2530000</CodigoMunicipio>
                                        </Servico>
                                        <Prestador>
                                            <CpfCnpj>
                                                <Cpf>24329550130</Cpf>
                                            </CpfCnpj>
                                            <InscricaoMunicipal>1442678</InscricaoMunicipal>
                                        </Prestador>
                                        <Tomador>
                                            <IdentificacaoTomador>
                                                <CpfCnpj>
                                                    <Cpf>28222148168</Cpf>
                                                </CpfCnpj>
                                                <InscricaoMunicipal>1708</InscricaoMunicipal>
                                            </IdentificacaoTomador>
                                            <RazaoSocial>LUIZ AUGUSTO MARINHO NOLETO</RazaoSocial>
                                            <Endereco>
                                                <Endereco>RUA 3</Endereco>
                                                <Numero>1003</Numero>
                                                <Complemento>1003</Complemento>
                                                <Bairro>CENTRO</Bairro>
                                                <CodigoMunicipio>5208707</CodigoMunicipio>
                                                <Uf>GO</Uf>
                                            </Endereco>
                                        </Tomador>
                                    </InfDeclaracaoPrestacaoServico>
                                    <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
                                        <SignedInfo>
                                            <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                                            <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
                                            <Reference URI="#rps1F">
                                                <Transforms>
                                                    <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
                                                    <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                                                </Transforms>
                                                <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
                                                <DigestValue>QYA7+yAGArVZrQU9joIj7i6ueUY=</DigestValue>
                                            </Reference>
                                        </SignedInfo>
                                        <SignatureValue>Oo0FSgAjwiDtFiMr8mqjYsMIHSB4oWnQq932xb1XQ7Jysa2J2f9IUzuQ1CCNw9QlgLg8CX3evz7+FOjSIwqIg5cE9BDlsh1e08w0BieurkhrYHRMtqBfbhUQzXHNJJU/F0+V5dsSLQ0qrK/DclegbLQY7yxLfn0pT9RbGQ6OIb8=</SignatureValue>
                                        <KeyInfo>
                                            <X509Data>
                                                <X509Certificate>MIIEqzCCA5OgAwIBAgIDMTg4MA0GCSqGSIb3DQEBBQUAMIGSMQswCQYDVQQGEwJCUjELMAkGA1UECBMCUlMxFTATBgNVBAcTDFBvcnRvIEFsZWdyZTEdMBsGA1UEChMUVGVzdGUgUHJvamV0byBORmUgUlMxHTAbBgNVBAsTFFRlc3RlIFByb2pldG8gTkZlIFJTMSEwHwYDVQQDExhORmUgLSBBQyBJbnRlcm1lZGlhcmlhIDEwHhcNMDkwNTIyMTcwNzAzWhcNMTAxMDAyMTcwNzAzWjCBnjELMAkGA1UECBMCUlMxHTAbBgNVBAsTFFRlc3RlIFByb2pldG8gTkZlIFJTMR0wGwYDVQQKExRUZXN0ZSBQcm9qZXRvIE5GZSBSUzEVMBMGA1UEBxMMUE9SVE8gQUxFR1JFMQswCQYDVQQGEwJCUjEtMCsGA1UEAxMkTkZlIC0gQXNzb2NpYWNhbyBORi1lOjk5OTk5MDkwOTEwMjcwMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCx1O/e1Q+xh+wCoxa4pr/5aEFt2dEX9iBJyYu/2a78emtorZKbWeyK435SRTbHxHSjqe1sWtIhXBaFa2dHiukT1WJyoAcXwB1GtxjT2VVESQGtRiujMa+opus6dufJJl7RslAjqN/ZPxcBXaezt0nHvnUB/uB1K8WT9G7ES0V17wIDAQABo4IBfjCCAXowIgYDVR0jAQEABBgwFoAUPT5TqhNWAm+ZpcVsvB7malDBjEQwDwYDVR0TAQH/BAUwAwEBADAPBgNVHQ8BAf8EBQMDAOAAMAwGA1UdIAEBAAQCMAAwgawGA1UdEQEBAASBoTCBnqA4BgVgTAEDBKAvBC0yMjA4MTk3Nzk5OTk5OTk5OTk5MDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDCgEgYFYEwBAwKgCQQHREZULU5GZaAZBgVgTAEDA6AQBA45OTk5OTA5MDkxMDI3MKAXBgVgTAEDB6AOBAwwMDAwMDAwMDAwMDCBGmRmdC1uZmVAcHJvY2VyZ3MucnMuZ292LmJyMCAGA1UdJQEB/wQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDBTBgNVHR8BAQAESTBHMEWgQ6BBhj9odHRwOi8vbmZlY2VydGlmaWNhZG8uc2VmYXoucnMuZ292LmJyL0xDUi9BQ0ludGVybWVkaWFyaWEzOC5jcmwwDQYJKoZIhvcNAQEFBQADggEBAJFytXuiS02eJO0iMQr/Hi+Ox7/vYiPewiDL7s5EwO8A9jKx9G2Baz0KEjcdaeZk9a2NzDEgX9zboPxhw0RkWahVCP2xvRFWswDIa2WRUT/LHTEuTeKCJ0iF/um/kYM8PmWxPsDWzvsCCRp146lc0lz9LGm5ruPVYPZ/7DAoimUk3bdCMW/rzkVYg7iitxHrhklxH7YWQHUwbcqPt7Jv0RJxclc1MhQlV2eM2MO1iIlk8Eti86dRrJVoicR1bwc6/YDqDp4PFONTi1ddewRu6elGS74AzCcNYRSVTINYiZLpBZO0uivrnTEnsFguVnNtWb9MAHGt3tkR0gAVs6S0fm8=</X509Certificate>
                                            </X509Data>
                                        </KeyInfo>
                                    </Signature>
                                </Rps>
                            </GerarNfseEnvio>
        XML;

        $soapRequest = 
        <<<SOAP
        <?xml version="1.0" encoding="UTF-8"?>
            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                <soap12:Body>
                    <GerarNfse xmlns="http://nfse.goiania.go.gov.br/ws/">
                        <ArquivoXML>
                            <![CDATA[
                                {$xmlData}
                            ]]>
                        </ArquivoXML>
                    </GerarNfse>
                </soap12:Body>
            </soap12:Envelope>
        SOAP;
            
        $response = $this->NfseWSReq($wsdlUrl, $soapAction, $soapRequest);
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        return $response;
    }
    public function consultar(){
        echo "Consultar NFSe";
    }

}
