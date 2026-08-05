<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Dao\Carretilla\Carretilla as DaoCarretilla;
use Utilities\PayPal\PayPalRestApi;
use Utilities\Context;
use Utilities\Security;
use Utilities\Site;

class Accept extends PrivateController
{
    public function run(): void
    {
        $dataview = array();
        $token = $_GET["token"] ?? "";
        $session_token = $_SESSION["orderid"] ?? "";
        
        if ($token !== "" && $token == $session_token) {
            $env = Context::getContextByKey("PAYPAL_CLIENT_ENV");
            $paypalEnv = ($env === "PROD" || $env === "PRODUCTION") ? "production" : "sandbox";

            $PayPalRestApi = new PayPalRestApi(
                Context::getContextByKey("PAYPAL_CLIENT_ID"),
                Context::getContextByKey("PAYPAL_CLIENT_SECRET"),
                $paypalEnv
            );
            
            $result = $PayPalRestApi->captureOrder($session_token);
            
            if (isset($result->status) && $result->status == "COMPLETED") {
                $usercod = $_SESSION["checkout_usercod"] ?? Security::getUserId();
                if ($usercod) {
                    DaoCarretilla::clearCarretillaByUser($usercod);
                    
                    unset($_SESSION["orderid"]);
                    unset($_SESSION["checkout_usercod"]);
                }
                
                Site::redirectToWithMsg("index.php?page=Index", "¡Pago completado con éxito! Gracias por tu compra.");
            } else {
                Site::redirectToWithMsg("index.php?page=Carretilla_Carretilla", "El pago no pudo completarse o fue rechazado.");
            }
            
        } else {
            $dataview["orderjson"] = "No Order Available!!!";
            \Views\Renderer::render("paypal/accept", $dataview);
        }
    }
}