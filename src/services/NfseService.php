<?php

require_once('CertificateService.php');

class Nfse {
    public  $numero;
    public  $serie;
    public  $tipo;
    public  $dataEmissao;
    public  $status;
    public  $valorServicos;
    public  $valorPis;
    public  $valorCofins;
    public  $valorInss;
    public  $valorCsll;
    public  $descontoIncondicionado;
    public  $codigoTributacaoMunicipio;
    public  $discriminacao;
    public  $codigoMunicipio;
    public  $cpfCnpjPrestador;
    public  $inscricaoMunicipalPrestador;
    public  $cpfCnpjTomador;
    public  $inscricaoMunicipalTomador;
    public  $razaoSocialTomador;
    public  $enderecoTomador;
    public  $numeroTomador;
    public  $complementoTomador;
    public  $bairroTomador;
    public  $codigoMunicipioTomador;
    public  $ufTomador;

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
       Nfse $nfse,
       $certificado,
       $senha
    ){
       
        
        $wsdlUrl = "https://nfse.goiania.go.gov.br/ws/nfse.asmx";

      
        $soapAction = "http://nfse.goiania.go.gov.br/ws/GerarNfse";

       
       
        
        $xmlData = 
        <<<XML
        <GerarNfseEnvio xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd">
                                <Rps>
                                    <InfDeclaracaoPrestacaoServico xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd">
                                        <Rps Id="rps1F">
                                            <IdentificacaoRps>
                                                <Numero>$nfse->numero</Numero>
                                                <Serie>$nfse->serie</Serie>
                                                <Tipo>$nfse->tipo</Tipo>
                                            </IdentificacaoRps>
                                            <DataEmissao>$nfse->dataEmissao</DataEmissao>
                                            <Status>$nfse->status</Status>
                                        </Rps>
                                        <Servico>
                                            <Valores>
                                                <ValorServicos>$nfse->valorServicos</ValorServicos>
                                                <ValorPis>$nfse->valorPis</ValorPis>
                                                <ValorCofins>$nfse->valorCofins</ValorCofins>
                                                <ValorInss>$nfse->valorInss</ValorInss>
                                                <ValorCsll>$nfse->valorCsll</ValorCsll>
                                                <DescontoIncondicionado>$nfse->descontoIncondicionado</DescontoIncondicionado>
                                            </Valores>
                                            <CodigoTributacaoMunicipio>$nfse->codigoTributacaoMunicipio</CodigoTributacaoMunicipio>
                                            <Discriminacao>$nfse->discriminacao</Discriminacao>
                                            <CodigoMunicipio>$nfse->codigoMunicipio</CodigoMunicipio>
                                        </Servico>
                                        <Prestador>
                                            <CpfCnpj>
                                                <Cpf>$nfse->cpfCnpjPrestador</Cpf>
                                            </CpfCnpj>
                                            <InscricaoMunicipal>$nfse->inscricaoMunicipalPrestador</InscricaoMunicipal>
                                        </Prestador>
                                        <Tomador>
                                            <IdentificacaoTomador>
                                                <CpfCnpj>
                                                    <Cpf>$nfse->cpfCnpjTomador</Cpf>
                                                </CpfCnpj>
                                                <InscricaoMunicipal>$nfse->inscricaoMunicipalTomador</InscricaoMunicipal>
                                            </IdentificacaoTomador>
                                            <RazaoSocial>$nfse->razaoSocialTomador</RazaoSocial>
                                            <Endereco>
                                                <Endereco>$nfse->enderecoTomador</Endereco>
                                                <Numero>$nfse->numeroTomador</Numero>
                                                <Complemento>$nfse->complementoTomador</Complemento>
                                                <Bairro>$nfse->bairroTomador</Bairro>
                                                <CodigoMunicipio>$nfse->codigoMunicipioTomador</CodigoMunicipio>
                                                <Uf>$nfse->ufTomador</Uf>
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
                                                <DigestValue></DigestValue>
                                            </Reference>
                                        </SignedInfo>
                                        <SignatureValue></SignatureValue>
                                        <KeyInfo>
                                            <X509Data>
                                                <X509Certificate>$certificado</X509Certificate>
                                            </X509Data>
                                        </KeyInfo>
                                    </Signature>
                                </Rps>
                            </GerarNfseEnvio>
        XML;
        $signatureService = new certificate($certificado, $senha);
        //echo $xmlData;
        $signature = $signatureService->signData($xmlData, $certificado);
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
        //print_r($response);
        return $response;
    }
  

}
?>