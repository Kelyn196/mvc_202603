<?php
namespace Controllers\Carretilla;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Carretilla\Carretilla as DaoCarretilla;
use Dao\Products\Products as DaoProducts;
use Utilities\Site;
use Utilities\Security;

class Carretilla extends PrivateController
{
    private $viewData = [];

    public function run(): void
    {
        // Obtiene el ID del usuario logueado (ajusta si tu método se llama diferente)
        $usercod = Security::getUserId(); 
        
        $action = $_GET["action"] ?? $_POST["action"] ?? "VIEW";
        
        // Manejo de acciones (Agregar, Actualizar, Eliminar)
        if ($this->isPostBack() || isset($_GET["action"])) {
            $productId = intval($_POST["productId"] ?? $_GET["productId"] ?? 0);
            
            switch ($action) {
                case "ADD":
                    $crrctd = intval($_POST["crrctd"] ?? 1);
                    $product = DaoProducts::getProductById($productId);
                    if ($product && $product["productStatus"] === "DISPO") {
                        DaoCarretilla::addToCarretilla($usercod, $productId, $crrctd, $product["productPrice"]);
                        Site::redirectToWithMsg("index.php?page=Carretilla_Carretilla", "Producto agregado a la carretilla");
                    }
                    break;
                    
                case "UPD":
                    // Si viene del formulario de actualización masiva
                    if (isset($_POST["items"]) && is_array($_POST["items"])) {
                        foreach ($_POST["items"] as $item) {
                            $pid = intval($item["productId"]);
                            $qty = intval($item["crrctd"]);
                            DaoCarretilla::updateQuantity($usercod, $pid, $qty);
                        }
                    }
                    Site::redirectTo("index.php?page=Carretilla_Carretilla");
                    break;
                    
                case "DEL":
                    DaoCarretilla::removeFromCarretilla($usercod, $productId);
                    Site::redirectToWithMsg("index.php?page=Carretilla_Carretilla", "Producto eliminado de la carretilla");
                    break;
            }
        }

        // Obtener datos para la vista
        $items = DaoCarretilla::getCarretillaByUser($usercod);
        $totalGeneral = 0;

        foreach ($items as &$item) {
            $item["subtotal"] = $item["crrctd"] * $item["crrprc"];
            $totalGeneral += $item["subtotal"];
        }

        $this->viewData["items"] = $items;
        $this->viewData["totalGeneral"] = $totalGeneral;

        Renderer::render("carretilla/carretilla", $this->viewData);
    }
}