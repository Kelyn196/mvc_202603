<?php

namespace Utilities\PayPal;

use Utilities\Paypal\PayPalOrder;

class PayPalRestApi
{
    private $_baseUrl;
    private $_clientId;
    private $_clientSecret;
    private $_token;
    private $_tokenExpiration;
    private $_tokenType;
    private $_tokenScope;
    private $_tokenAppId;
    private $_tokenNonce;

    public function __construct(string $clientId, string $clientSecret, $environment = "sandbox")
    {
        $this->_clientId = trim($clientId);
        $this->_clientSecret = trim($clientSecret);
        
        if ($environment === "production" || $environment === "PROD" || $environment === "PRODUCTION") {
            $this->_baseUrl = "https://api-m.paypal.com";
        } else {
            $this->_baseUrl = "https://api-m.sandbox.paypal.com";
        }
    }

    public function getAccessToken()
    {
        if ($this->_token == null || $this->_tokenExpiration < time()) {
            $this->requestAccessToken();
        }
        return $this->_token;
    }

    private function requestAccessToken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_baseUrl . "/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_USERPWD => $this->_clientId . ":" . $this->_clientSecret,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Accept: application/json"
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($response === false) {
            throw new \Exception("Error de red cURL al conectar con PayPal: " . $curlError);
        }

        $responseData = json_decode($response);

        if ($httpCode !== 200) {
            $errorMsg = isset($responseData->error_description) ? $responseData->error_description : $response;
            throw new \Exception("PayPal rechazó la autenticación (HTTP {$httpCode}). Detalle: {$errorMsg}");
        }

        if (!isset($responseData->access_token)) {
            throw new \Exception("Respuesta de PayPal válida, pero no contiene 'access_token'. Respuesta cruda: " . $response);
        }

        $this->_token = $responseData->access_token;
        $this->_tokenExpiration = time() + $responseData->expires_in;
        $this->_tokenType = $responseData->token_type;
        $this->_tokenScope = $responseData->scope ?? '';
        $this->_tokenAppId = $responseData->app_id ?? '';
        $this->_tokenNonce = $responseData->nonce ?? '';
    }
    
    public function createOrder(PayPalOrder $order)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_baseUrl . "/v2/checkout/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($order->getOrder()),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->getAccessToken(),
                "Accept: application/json"
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $responseData = json_decode($response);
        
        if ($httpCode >= 400) {
            throw new \Exception("Error al crear la orden en PayPal (HTTP {$httpCode}): " . json_encode($responseData));
        }
        
        return $responseData;
    }
    
    public function captureOrder($orderId)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_baseUrl . "/v2/checkout/orders/" . $orderId . "/capture",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->getAccessToken(),
                "Accept: application/json"
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $responseData = json_decode($response);
        
        if ($httpCode >= 400) {
            throw new \Exception("Error al capturar la orden en PayPal (HTTP {$httpCode}): " . json_encode($responseData));
        }
        
        return $responseData;
    }
}