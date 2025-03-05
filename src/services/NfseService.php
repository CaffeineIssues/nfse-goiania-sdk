<?php

class NfseService{
    

 public function gerar(
        /*$rpsNumero,
        $rpsSerie,
        $rpsTipo,
        $dataEmissao,
        $rpsStatus,
        $valorServicos,
        $valorPis,
        $valorCofins,
        $valorInss,
        $valorCsll,
        $codigoTributacaoMunicipio,
        $discriminacao,
        $codigoMunicipio,
        $cpfPrestador,
        $inscricaoMunicipalPrestador,
        $cnpjTomador,
        $inscricaoMunicipalTomador,
        $razaoSocialTomador,
        $endereco,
        $numero,
        $complemento,
        $bairro,
        $uf,
        $digestValue,
        $signatureValue,
        $x509Certificate*/
    ){
       
        // NFSe Web Service URL
        $wsdlUrl = "https://nfse.goiania.go.gov.br/ws/nfse.asmx";

        // SOAP Action
        $soapAction = "http://nfse.goiania.go.gov.br/ws/GerarNfse";

        // RPS Data
        $rpsNumero = "18";
        $rpsSerie = "UNICA";
        $rpsTipo = "1";
        $dataEmissao = "2011-11-16T00:00:00";
        $rpsStatus = "1";

        // Service Values
        $valorServicos = "2000.00";
        $valorPis = "40.50";
        $valorCofins = "20.00";
        $valorInss = "10.50";
        $valorCsll = "30.00";

        // Taxation and Description
        $codigoTributacaoMunicipio = "551080100";
        $discriminacao = "TESTE DE WEBSERVICE RETIDO";
        $codigoMunicipio = "2530000";

        // Provider (Prestador)
        $cpfPrestador = "24329550130";
        $inscricaoMunicipalPrestador = "1300687";

        // Customer (Tomador)
        $cnpjTomador = "06926334000177";
        $inscricaoMunicipalTomador = "2118513";
        $razaoSocialTomador = "GRAMADO EMPREENDIMENTOS";

        // Address
        $endereco = "RUA 3";
        $numero = "1003";
        $complemento = "1003";
        $bairro = "CAPUAVA";
        $uf = "GO";

        // XML Signature (Dummy Data)
        $digestValue = "Rx/dhFhnjN/6mxk02LrNmpvM5lU=";
        $signatureValue = "Y3UQi0Q4GKEuhGejjl44TSlXG6JZ4OPrVS...";
        $x509Certificate = "MIIF1zCCBL+gAwIBAgIQMjAxMDA4MTMxODQwMjc5OTAN...";

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

        // SOAP Envelope
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

        // Setup cURL
        $ch = curl_init();
        echo  $soapRequest;
        // cURL options
        curl_setopt($ch, CURLOPT_URL, $wsdlUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soapRequest);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: text/xml; charset=utf-8",
            "SOAPAction: \"$soapAction\"",
            "Content-Length: " . strlen($soapRequest),
        ]);

        // Execute cURL
        $response = curl_exec($ch);
        $json_response;
       // echo $response;
        // Check for errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            
            $response_headers = curl_getinfo($ch);
            if($response_headers['http_code'] == 400){
                $json_response =  json_encode(["error" => "Erro ao gerar NFSe", "message" => "requisição invalida(possivel erro no xml enviado)", "status" => 400]);
                echo $json_response;
                return $json_response;
            }
            if($response_headers['http_code'] == 500){
                $json_response =  json_encode(["error" => "Erro ao gerar NFSe", "message" => "Erro interno no servidor", "status" => 500]);
                echo $json_response;
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
            print_r($json_response);
            $xmlObject = simplexml_load_string($json_response);
            return($xmlObject);        
        }

        // Close cURL
        curl_close($ch);
    }
    public function consultar(){
        echo "Consultar NFSe";
    }

}
