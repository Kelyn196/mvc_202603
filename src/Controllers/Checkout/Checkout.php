<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Dao\Carretilla\Carretilla as DaoCarretilla;
use Utilities\Paypal\PayPalOrder;
use Utilities\PayPal\PayPalRestApi;
use Utilities\Context;
use Utilities\Site;
use Utilities\Security;

class Checkout extends PrivateController
{
    public function run(): void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $usercod = Security::getUserId();
        if (!$usercod) {
            Site::redirectToWithMsg("index.php?page=Login_Login", "Debes iniciar sesión para continuar con el pago.");
            return;
        }

        $items = DaoCarretilla::getCarretillaByUser($usercod);
        if (empty($items)) {
            Site::redirectToWithMsg("index.php?page=Carretilla_Carretilla", "Tu carretilla está vacía.");
            return;
        }

        $referenceID = "ORD-" . $usercod . "-" . time();
        
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        
        if ($scriptDir === '/' || $scriptDir === '\\') {
            $baseUrl = $protocol . "://" . $host . "/";
        } else {
            $baseUrl = $protocol . "://" . $host . $scriptDir . "/";
        }

        $cancelUrl = str_replace('\\', '/', $baseUrl . "index.php?page=Checkout_Error");
        $returnUrl = str_replace('\\', '/', $baseUrl . "index.php?page=Checkout_Accept");

        $currency = "USD";
        $PayPalOrder = new PayPalOrder($referenceID, $cancelUrl, $returnUrl, $currency);

        foreach ($items as $item) {
            $price = number_format((float)$item['crrprc'], 2, '.', '');
            $tax = "0.00";
            $qty = (int)$item['crrctd'];
            
            $name = substr($item['productName'], 0, 127);
            $desc = substr($item['productDescription'], 0, 127);
            $sku = "PRD-" . $item['productId'];
            
            $PayPalOrder->addItem($name, $desc, $sku, $price, $tax, $qty, "PHYSICAL_GOODS");
        }

        $env = Context::getContextByKey("PAYPAL_CLIENT_ENV");
        $paypalEnv = ($env === "PROD" || $env === "PRODUCTION") ? "production" : "sandbox";

        $PayPalRestApi = new PayPalRestApi(
            Context::getContextByKey("PAYPAL_CLIENT_ID"),
            Context::getContextByKey("PAYPAL_CLIENT_SECRET"),
            $paypalEnv
        );
        
        try {
            $token = $PayPalRestApi->getAccessToken();
            if (!$token) {
                throw new \Exception("No se pudo obtener el Token de acceso de PayPal.");
            }

            $response = $PayPalRestApi->createOrder($PayPalOrder);

            if (isset($response->id) && isset($response->links)) {
                $_SESSION["orderid"] = $response->id;
                $_SESSION["checkout_usercod"] = $usercod;
                
                foreach ($response->links as $link) {
                    if ($link->rel == "approve") {
                        Site::redirectTo($link->href);
                        die();
                    }
                }
                throw new \Exception("No se encontró el enlace de aprobación en la respuesta de PayPal.");
            } else {
                echo "<h2>Error al crear la orden de PayPal</h2>";
                echo "<h3>Respuesta de PayPal:</h3>";
                echo "<pre style='background:#f4f4f4; padding:15px; border:1px solid #ccc; overflow:auto;'>";
                print_r($response);
                echo "</pre>";
                echo "<br><a href='index.php?page=Carretilla_Carretilla'>Volver a la carretilla</a>";
                die();
            }

        } catch (\Exception $e) {
            echo "<h2>Excepción capturada:</h2>";
            echo "<pre style='background:#ffe6e6; padding:15px; border:1px solid #ff0000; color:#cc0000;'>";
            echo "Error: " . $e->getMessage() . "\n";
            echo "Archivo: " . $e->getFile() . " (Línea " . $e->getLine() . ")";
            echo "</pre>";
            die();
        }
    }
}