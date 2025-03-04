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
        $xmlData = <<<XML
        <?xml version="1.0"?>
        <GerarNfseEnvio xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd">
        <Rps>
            <InfDeclaracaoPrestacaoServico>
            <Rps>
                <IdentificacaoRps>
                <Numero>{$rpsNumero}</Numero>
                <Serie>{$rpsSerie}</Serie>
                <Tipo>{$rpsTipo}</Tipo>
                </IdentificacaoRps>
                <DataEmissao>{$dataEmissao}</DataEmissao>
                <Status>{$rpsStatus}</Status>
            </Rps>
            <Servico>
                <Valores>
                <ValorServicos>{$valorServicos}</ValorServicos>
                <ValorPis>{$valorPis}</ValorPis>
                <ValorCofins>{$valorCofins}</ValorCofins>
                <ValorInss>{$valorInss}</ValorInss>
                <ValorCsll>{$valorCsll}</ValorCsll>
                </Valores>
                <CodigoTributacaoMunicipio>{$codigoTributacaoMunicipio}</CodigoTributacaoMunicipio>
                <Discriminacao>{$discriminacao}</Discriminacao>
                <CodigoMunicipio>{$codigoMunicipio}</CodigoMunicipio>
            </Servico>
            <Prestador>
                <CpfCnpj>
                <Cpf>{$cpfPrestador}</Cpf>
                </CpfCnpj>
                <InscricaoMunicipal>{$inscricaoMunicipalPrestador}</InscricaoMunicipal>
            </Prestador>
            <Tomador>
                <IdentificacaoTomador>
                <CpfCnpj>
                    <Cnpj>{$cnpjTomador}</Cnpj>
                </CpfCnpj>
                <InscricaoMunicipal>{$inscricaoMunicipalTomador}</InscricaoMunicipal>
                </IdentificacaoTomador>
                <RazaoSocial>{$razaoSocialTomador}</RazaoSocial>
                <Endereco>
                <Endereco>{$endereco}</Endereco>
                <Numero>{$numero}</Numero>
                <Complemento>{$complemento}</Complemento>
                <Bairro>{$bairro}</Bairro>
                <CodigoMunicipio>{$codigoMunicipio}</CodigoMunicipio>
                <Uf>{$uf}</Uf>
                </Endereco>
            </Tomador>
            </InfDeclaracaoPrestacaoServico>
            <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
            <SignedInfo>
                <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
                <Reference URI="">
                <Transforms>
                    <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
                    <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
                <DigestValue>{$digestValue}</DigestValue>
                </Reference>
            </SignedInfo>
            <SignatureValue>{$signatureValue}</SignatureValue>
            <KeyInfo>
                <X509Data>
                <X509Certificate>{$x509Certificate}</X509Certificate>
                </X509Data>
            </KeyInfo>
            </Signature>
        </Rps>
        </GerarNfseEnvio>
        XML;

        // SOAP Envelope
        $soapRequest = <<<SOAP
        <?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                    xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
                    xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <GerarNfse xmlns="http://nfse.goiania.go.gov.br/ws/">
            <ArquivoXML><![CDATA[$xmlData]]></ArquivoXML>
            </GerarNfse>
        </soap:Body>
        </soap:Envelope>
        SOAP;

        // Setup cURL
        $ch = curl_init();

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

        // Check for errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            echo 'Response: ' . htmlspecialchars($response);
        }

        // Close cURL
        curl_close($ch);
    }
    public function consultar(){
        echo "Consultar NFSe";
    }

}
